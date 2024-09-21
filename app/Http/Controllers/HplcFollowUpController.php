<?php

namespace App\Http\Controllers;

// モデルを使用するために追加
use App\Models\HplcResult;    // モデルを使用するために追加
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class HplcFollowUpController extends Controller
{
    private function extractKeywords($query)
    {
        // シンプルな例として、スペースで区切ることでキーワードを抽出
        // より高度な方法を使用して、意味のあるキーワードを抽出することも可能
        return explode(' ', $query);
    }

    public function askAgain(Request $request)
    {
        $previousQuestion = $request->input('previousQuestion');
        $previousResponse = $request->input('previousResponse');
        $followupQuestion = $request->input('followupQuestion');
    
        // 最新の質問をベクトル化して検索に使用する
        $query = $followupQuestion;
        $vector = $this->vectorize($query);
    
        $fragments = HplcResult::with('user')->get();
        $results = [];
        
        foreach ($fragments as $fragment) {
            $storedVector = json_decode($fragment->vector, true);
            if (is_null($storedVector)) {
                Log::error('Stored vector is null', ['fragment_id' => $fragment->id]);
                continue;
            }
            $similarity = $this->cosineSimilarity($vector, $storedVector);
            $results[] = ['fragment' => $fragment, 'similarity' => $similarity];
        }
    
        usort($results, function ($a, $b) {
            return $b['similarity'] <=> $a['similarity'];
        });

        // クエリからキーワードを抽出
        $keywords = $this->extractKeywords($query);
    
        $filteredResults = array_filter($results, function($result) use ($keywords) {
            foreach ($keywords as $keyword) {
                if (stripos($result['fragment']->content, $keyword) !== false) {
                    return true;
                }
            }
            return false;
        });
    
        // もしキーワードに一致するフラグメントがなければ、上位5つの結果を使用
        if (empty($filteredResults)) {
            $filteredResults = array_slice($results, 0, 5);
        }
    
    
        $context = implode("\n", array_map(function($result) {
            return $result['fragment']->content . '\nFile_Path: ' . $result['fragment'];
        }, array_slice($filteredResults, 0, 5)));
    
        $apiKey = env('OPENAI_API_KEY');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are an expert assistant specializing in retrieving and analyzing chemical data. Your goal is to provide accurate and relevant information based on the provided context, including past interactions and user queries. When answering a follow-up question:

                    1. Consider the previous response and the user follow-up question carefully to ensure continuity and relevance.
                    2. Once you find the analysis information, present one to three records in your recommended order, following the format below:
                    <table>
                        <tr><th>Date</th>   <th class="pl-2">Code</th>   <th class="pl-2">Column Name</th>      <th class="pl-2">Main Peak Purity</th> <th class="pl-2">File_Path</th></tr>
                        <tr><td>{date1}</td><td class="pl-2">{code1}</td>  <td class="pl-2">{column_name1}</td>   <td class="pl-2">{purity1}%</td>       <td class="pl-2 text-xs">(File_Path_url1)</td></tr>
                        <tr><td>{date2}</td><td class="pl-2">{code2}</td>  <td class="pl-2">{column_name2}</td>   <td class="pl-2">{purity2}%</td>       <td class="pl-2 text-xs">(File_Path_url2)</td></tr>
                        <tr><td>{date3}</td><td class="pl-2">{code3}</td>  <td class="pl-2">{column_name3}</td>   <td class="pl-2">{purity3}%</td>       <td class="pl-2 text-xs">(File_Path_url3)</td></tr>
                    </table>
                    3. Finally, provide a brief summary of the presented data in a clear and concise manner.'
                ],
                [
                    'role' => 'assistant',
                    'content' => "previousResponse: $previousResponse"
                ],
                [
                    'role' => 'user',
                    'content' => "previousQuestion: $previousQuestion \nFollow-up Question: $followupQuestion\nContext: $context\nAnswer:"
                ],
                
            ],
            'max_tokens' => 600,
            'temperature' => 0.7,
        ]);
    
        if ($response->successful()) {
            $aiFollowupResponse = $response->json()['choices'][0]['message']['content'];
        
            // URLやファイルパスをリンクに変換する
            $aiResponseWithLinks = preg_replace_callback(
                '~(uploads/\S+\.\w+)~',
                function ($matches) {
                    // リンクが既に存在していない場合のみ、リンクを作成する
                    return '<a href="' . asset($matches[1]) . '" target="_blank"  class="text-sky-500 hover:text-sky-700" target="_blank">' . $matches[1] . '</a>';
                },
                strip_tags($aiFollowupResponse, '<table><tr><th><td><br>') // テーブルタグは維持して、それ以外のタグは削除
            );
            
            Log::info('AI Response with links: ' . $aiResponseWithLinks);
        } else {
            Log::error('OpenAI follow-up request failed', ['status' => $response->status(), 'body' => $response->body()]);
            $aiResponseWithLinks = 'Failed to get a response from the OpenAI service.';
        }
        
        return view('hplcs/response', [
            'question' => "past question: " . nl2br(e($previousQuestion)) . "<br><br>" . "new question: ". nl2br(e($followupQuestion)),
            'aiResponse' => $aiResponseWithLinks, 
            'results' => $results // RAGの結果を再度表示
        ]);
    }

    private function vectorize($text)
    {
        $apiKey = env('OPENAI_API_KEY'); // OpenAI APIキーを取得

        $response = Http::withHeaders([ 
            'Authorization' => 'Bearer ' . $apiKey,  
            ])->post('https://api.openai.com/v1/embeddings', [
                'model' => 'text-embedding-3-small',  // 使用するモデル
                'input' => $text,  // 質問内容を送信
            ]);
        
       
        if ($response->successful()) {
            return $response->json()['data'][0]['embedding'];; // ベクトルを返す
        } else {
            Log::error('OpenAI request failed', ['status' => $response->status(), 'body' => $response->body()]);
            return array_fill(0, 512, 0); 
        }
    }

    private function cosineSimilarity($vec1, $vec2) // コサイン類似度を計算
    {
        if (!is_array($vec1) || !is_array($vec2)) { // ベクトルが配列でない場合はエラー
            Log::error('Vectors must be arrays', ['vec1' => $vec1, 'vec2' => $vec2]);   // エラーログを出力
            return 0;   // 類似度を0として返す
        }

        $dotProduct = array_sum(array_map(function($a, $b) { return $a * $b; }, $vec1, $vec2)); // 内積を計算
        $magnitude1 = sqrt(array_sum(array_map(function($a) { return $a * $a; }, $vec1)));  // ベクトル1の大きさを計算
        $magnitude2 = sqrt(array_sum(array_map(function($a) { return $a * $a; }, $vec2)));  // ベクトル2の大きさを計算

        if ($magnitude1 == 0 || $magnitude2 == 0) { // どちらかのベクトルの大きさが0の場合はエラー
            return 0;   // 類似度を0として返す
        }

        return $dotProduct / ($magnitude1 * $magnitude2);   // コサイン類似度を計算して返す
    }





}
