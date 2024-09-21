<?php
namespace App\Http\Controllers;


use App\Models\HplcQuestion;
use App\Models\HplcResult;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class hplcRecordController extends Controller
{
    public function index()
    {
        $resultsCount = HplcResult::count();
        $recent30s=HplcQuestion::orderBy('created_at','desc')->take(30)->paginate(10);
        $years = HplcResult::selectRaw('YEAR(created_at) as year') 
            ->groupBy('year')   // 重複を削除
            ->orderby('year', 'desc')   // 降順
            ->pluck('year'); // 1つのカラムのみ取得
        $departments = User::distinct()->pluck('department');   

        return view('hplcs/record', compact('resultsCount','recent30s','years', 'departments'));
    }

    public function departmentCount(Request $request)
    {
        $selectedYear = $request->input('year', date('Y')); // リクエストがない場合は今年を選択
        // Log::debug($selectedYear); // ログで確認

        $years = HplcResult::selectRaw('YEAR(created_at) as year') 
            ->groupBy('year')   // 重複を削除
            // ->distinct() // 重複を削除
            ->orderby('year', 'desc')   // 降順
            ->pluck('year'); // 1つのカラムのみ取得


        // 下記はjoinmethotdを使った例
        // $annuals = HplcResult::join('users', 'hplc_results.user_id', '=', 'users.id') // usersテーブルと結合
        //     ->select('users.department', DB::raw('count(hplc_results.id) as count')) // departmentカラムと、hplc_resultsのidカラムの数を取得
        //     ->whereYear('hplc_results.created_at', $selectedYear) // 選択した年のデータのみ取得
        //     ->groupby('users.department') // departmentカラムでグループ化
        //     ->get();
        //     Log::debug($annuals);
        $annuals = HplcResult::with('user') // usersテーブルと結合
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
            $yearlyPosts = HplcResult::where('user_id', $user->id)
            ->selectRaw('YEAR(created_at) as year, count(*) as count')
            ->groupBy('year')
            ->pluck('count','year');

            return [
                'name' => $user->name,
                'posts' => $yearlyPosts,
            ];
        });
        
        $years = HplcResult::selectRaw('YEAR(created_at) as year')
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