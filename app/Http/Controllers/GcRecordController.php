<?php
namespace App\Http\Controllers;


use App\Models\GcQuestion;
use App\Models\GcResult;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;


class gcRecordController extends Controller
{
    public function index(Request $request)
    {
        $resultsCount = GcResult::count();
        // $recent30s=GcQuestion::orderBy('created_at','desc')->take(30)->paginate(10);
        $recent30s = GcQuestion::orderBy('created_at', 'desc')->take(30)->get();
        
        $perPage = 10; // 1ページあたりの表示件数
        $currentPage = LengthAwarePaginator::resolveCurrentPage(); // 現在のページを取得
        $currentItems = $recent30s->slice(($currentPage - 1) * $perPage, $perPage)->all(); // 現在のページのアイテムを取得
        $paginatedItems = new LengthAwarePaginator(
            $currentItems, // 現在のページのデータ
            $recent30s->count(), // 全データ数
            $perPage, // 1ページあたりの表示件数
            $currentPage, // 現在のページ
            ['path' => $request->url(), 'query' => $request->query()] // ページネーションリンクのパスとクエリ
        );

        $years = GcResult::selectRaw('YEAR(created_at) as year') 
            ->groupBy('year')   // 重複を削除
            ->orderby('year', 'desc')   // 降順
            ->pluck('year'); // 1つのカラムのみ取得
        $departments = User::distinct()->pluck('department');   

        return view('gcs/record', compact('resultsCount','paginatedItems', 'years', 'departments'));
    }

    public function departmentCount(Request $request)
    {
        $selectedYear = $request->input('year', date('Y')); // リクエストがない場合は今年を選択
        // Log::debug($selectedYear); // ログで確認

        $years = GcResult::selectRaw('YEAR(created_at) as year') 
            ->groupBy('year')   // 重複を削除
            // ->distinct() // 重複を削除
            ->orderby('year', 'desc')   // 降順
            ->pluck('year'); // 1つのカラムのみ取得


        // 下記はjoinmethotdを使った例
        // $annuals = GcResult::join('users', 'gc_results.user_id', '=', 'users.id') // usersテーブルと結合
        //     ->select('users.department', DB::raw('count(gc_results.id) as count')) // departmentカラムと、gc_resultsのidカラムの数を取得
        //     ->whereYear('gc_results.created_at', $selectedYear) // 選択した年のデータのみ取得
        //     ->groupby('users.department') // departmentカラムでグループ化
        //     ->get();
        //     Log::debug($annuals);
        $annuals = GcResult::with('user') // usersテーブルと結合
            ->whereYear('created_at', $selectedYear) // 選択した年のデータのみ取得
            ->get() // すべてのデータを取得
            ->groupBy('user.department') // departmentカラムでグループ化
            ->map(function ($group){
                return ['department' => $group->first()->user->department, 
                        'count' => $group->count(),
                ];
            }); 
        
        return response()->json(['annuals' => $annuals, 'years' => $years]);
    }


    public function personalStats(Request $request)
    {
        $user = Auth::user();
        // $department = $user->department;
        $selectedDepartment = $request->input('department', Auth::user()->department);
        log::debug($selectedDepartment);
        $userSameDepartment = User::where('department', $selectedDepartment)->get();
        
        $userStats = $userSameDepartment->map(function ($user) {
            $yearlyPosts = GcResult::where('user_id', $user->id)
            ->selectRaw('YEAR(created_at) as year, count(*) as count')
            ->groupBy('year')
            ->pluck('count','year');

            return [
                'name' => $user->name,
                'posts' => $yearlyPosts,
            ];
        });
        
        $years = GcResult::selectRaw('YEAR(created_at) as year')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');

        return response()->json(['userStats' => $userStats, 'years' => $years]);
    }


    public function show()
    {

    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function destroy($id)
    {
    }
}