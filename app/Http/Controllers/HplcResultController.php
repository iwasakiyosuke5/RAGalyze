<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;

use App\Models\HplcResult;


class HplcResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 検索できるようした
        $query = HplcResult::where('user_id', auth()->id());
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('content', 'like', "%{$search}%")
                ->orWhere('file_path', 'like', "%{$search}%");
            });
        }
        $mines = $query->orderBy('updated_at','desc')->paginate(5)->withQueryString();
        return view('hplcs.myPosts', compact('mines'));
        // // 下記は検索しない場合
        // $mines = HplcResult::where('user_id', auth()->id())→orderBy('updated_at','desc')->paginate(5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id, Request $request)
    {
        
        $post = HplcResult::where('id', $id)->firstOrFail(); 
        
        // ポストのユーザーIDとログインユーザーIDが一致しない場合
        if ($post->user_id !== auth()->id()) {
            // 所有者でない場合は403エラーを返す
            abort(403, 'You do not have permission to view this data.');
        }

        $query = HplcResult::where('user_id', auth()->id());

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('content', 'like', '%' . $search . '%')
                  ->orWhere('file_path', 'like', '%' . $search . '%');
            });
        }
    
        // 検索結果のページネーションを保持
        $mines = $query->orderBy('updated_at', 'desc')->paginate(5)->withQueryString();
        
        $textData = $post->content;
        $imageData = base64_encode(file_get_contents(public_path($post->file_path)));
        return view('hplcs/myPosts', compact('mines', 'post', 'textData', 'imageData'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HplcResult $hplcResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HplcResult $hplcResult)
    {
        $request->validate([
            'text_data' => 'required|string',
        ]);
        $text = $request->input('text_data');
        $vector = $this->vectorizeWithOpenAI($text);
        if ($vector === null) {
            return back()->withErrors(['msg' => 'ベクトル化に失敗しました。']);
        }

        $hplcResult->update([
            'content' => $text,
            'vector' => json_encode($vector),
        ]);
        // 大量のレコードを一括で更新する場合や、モデルイベントが不要な場合は、下記のupdateメソッドを使う
        // HplcResult::where('id', $hplcResult->id)->update([
        //     'content' => $text,
        //     'vector' => json_encode($vector),
        // ]);

        return redirect()->route('hplcMyPosts')->with('success', 'データが更新されました。'); // マイページにリダイレクト

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HplcResult $hplcResult, Request $request)
    {
        // myPosts.blade.phpで削除ボタンを押した時の処理
        $hplcResult->delete();
        // 画像ファイルの削除
        $filePath = public_path($request->input('file_path'));
        // ファイルが存在するか確認して削除
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
        return redirect()->route('hplcMyPosts')->with('success', 'データが削除されました。'); 
    }
  //request.blade.phpからwatch.bladeに遷移 
    // PNGファイルを受け取り、OpenAI APIに送信
    public function convertPng(Request $request)
    {
        // PNGファイルの取得
        $originalName = $request->file('image_file')->getClientOriginalName();
        $filename = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '.' . $request->file('image_file')->extension();
        $filePath = $request->file('image_file')->move(public_path('uploads'), $filename);

        // PNG画像をBase64形式にエンコード
        // $imageData = base64_encode(file_get_contents($imagePath));
        $imageData = base64_encode(file_get_contents($filePath));

        return $this->sendToOpenAI($imageData, 'uploads/' . $filename);
    }

    // OpenAI APIにリクエストを送信
    private function sendToOpenAI($imageData, $filePath)
    {
        // OpenAI APIへのリクエスト準備
        $apiKey = env('OPENAI_API_KEY');
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $apiKey,
        ];

        $payload = [
            'model' => 'gpt-4o-mini', // 視覚モデルを使用
            'messages' => [
                [
                    'role' => 'user',
                    'content' => [
                        [
                            'type' => 'text',
                            'text' => "Please analyze the provided HPLC chromatogram image and categorize the information into the following sections:\n\n"
                                        . "1. Basic Information: If available, extract details such as the measurement date, compound or code, PO and other basic information. If an item is not found in the image, omit it.\n"
                                        . "2. Measurement Conditions: If provided, list the column used, INJ_Vol and other measurement conditions. Only include information that is specified in the image.\n"
                                        . "3. Peak Analysis: Identify and report the top two peak area percentages along with their retention times (RT). If only one peak is present, report that single peak.\n\n"
                                        . "Please conclude the response with only 'keyword:' and  'SMILEScode:' "],
                        [
                            'type' => 'image_url',
                            'image_url' => [
                                'url' => "data:image/png;base64,{$imageData}"
                            ]
                        ]
                    ]
                ]
            ],
            'max_tokens' => 300,
        ];

        // OpenAI APIにリクエストを送信
        $response = Http::withHeaders($headers)->post('https://api.openai.com/v1/chat/completions', $payload);

        // レスポンスの取得
        $result = $response->json();

        // テキストデータを次のページに送信
        $textData = $result['choices'][0]['message']['content'] ?? 'テキストデータが取得できませんでした。';
        return view('hplcs/watch', ['textData' => $textData, 'imageData' => $imageData, 'filePath' => $filePath]);
    }

  //watch.bladeからデータを登録する時の流れ  
    //watch.bladeでhplc_resultsテーブルにデータを保存
    public function upload(Request $request)
    {
        $request->validate([
            'text_data' => 'required|string',
            'file_path' => 'required|string',
        ]);

        $text = $request->input('text_data');
        $filePath = $request->input('file_path');
        // OpenAIでのベクトル化
        $vector = $this->vectorizeWithOpenAI($text);

        if ($vector === null) {
            return back()->withErrors(['msg' => 'ベクトル化に失敗しました。']);
        }

        // ユーザーIDの取得
        $userId = auth()->id();

        // データベースに保存
        HplcResult::create([
            'content' => $text,
            'vector' => json_encode($vector),
            'file_path' => $filePath,
            'user_id' => $userId, 
        ]);

        return redirect('hplcs/request')->with('success', 'データがアップロードされました。');
    }

    private function vectorizeWithOpenAI($text)
    {
        $apiKey = env('OPENAI_API_KEY');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
        ])->post('https://api.openai.com/v1/embeddings', [
            'model' => 'text-embedding-3-small',  // 使用するモデル
            'input' => $text,
        ]);

        if ($response->successful()) {
            return $response->json()['data'][0]['embedding'];
        } else {
            return null;
        }
    }

  
  // watch.blade.phpで画像ファイルを削除して再度request.bladeに戻る関数
    public function deleteAndRedirect(Request $request)
    {
        // 画像ファイルの削除
        $filePath = public_path($request->input('file_path'));
        // ファイルが存在するか確認して削除
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        return redirect()->route('hplcRequest');
    }



}
