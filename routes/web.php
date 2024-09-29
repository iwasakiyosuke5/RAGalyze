<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HplcResultController;
use App\Http\Controllers\HplcQuestionController;
use App\Http\Controllers\HplcFollowUpController;
use App\Http\Controllers\HplcRecordController;
use App\Http\Controllers\GcResultController;
use App\Http\Controllers\GcQuestionController;
use App\Http\Controllers\GcFollowUpController;
use App\Http\Controllers\GcRecordController;

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



// 認証が必要なルート
Route::middleware('auth')->group(function () {
    Route::get('/user-admin', [AdminController::class, 'index'])->name('userAdmin')->middleware('auth');

    // 編集ページを表示するルート
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('userEdit');

    // ユーザー情報を更新するルート
    Route::put('/user/{id}', [UserController::class, 'update'])->name('userUpdate');


    // プロフィール関連のルート
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
   
    //HPLCのルート 
        // hplc_resultsのルーティング
        Route::resource('hplc_results', HplcResultController::class);
        Route::post('hplc_upload', [HplcResultController::class, 'upload'])->name('hplc_upload');

        // hplc_questionsのルーティング
        Route::post('/search', [HplcQuestionController::class, 'store'])->name('search');
        Route::get('/hplc_response/{id}', [HplcQuestionController::class, 'response'])->name('hplc_response');
        Route::post('/hplc_responseAgain', [HplcFollowUpController::class, 'askAgain'])->name('askAgain');

        // HPLC関連のルートに認証を適用
        Route::get('/hplcs/top', function () {
            return view('hplcs.top');
        })->name('hplcTop');

        Route::get('/hplcs/request', function () {
            return view('hplcs.request');
        })->name('hplcRequest');

        Route::get('/hplcs/question', function () {
            return view('hplcs.question');
        })->name('hplcQuestion');

        Route::get('/hplcs/response', function () {
            return view('hplcs.response');
        })->name('hplcResponse');

        Route::get('/hplcs/record', function () {
            return view('hplcs.record');
        });

        Route::get('/hplcs/error', function () {
            return view('hplcs.error');
        })->name('hplcs.errorPage');

        // PNGデータの投稿
        Route::post('/convert/png', [HplcResultController::class, 'convertPng'])->name('convert.png');

        // hplcs/watchで結果を見た後、requestに戻る場合（画像の削除も行う）
        Route::post('delete-and-redirect', [HplcResultController::class, 'deleteAndRedirect'])->name('deleteAndRedirect');

        // 自分の投稿を表示
        Route::get('/hplcs/myPosts', [HplcResultController::class, 'index'])->name('hplcMyPosts');

        // 投稿詳細表示
        Route::get('/hplcs/myPosts/{id}', [HplcResultController::class, 'show'])->name('hplcChooseData');

        // 投稿の更新
        Route::put('/hplcs/myPosts/{hplc_result}', [HplcResultController::class, 'update'])->name('hplcUpdateData');

        // 投稿の削除
        Route::delete('/hplcs/myPosts/{hplc_result}', [HplcResultController::class, 'destroy'])->name('hplcDestroyData');

        // HPLCの記録を表示
        Route::get('/hplcs/record', [HplcRecordController::class, 'index'])->name('hplcRecord');

        // API関係のルーティング
        Route::get('api/department-count', [HplcRecordController::class, 'departmentCount'])->name('api.departmentCount');
        Route::get('api/personal-stats', [HplcRecordController::class, 'personalStats'])->name('api.personalStats');

    //GCのルート 
        // gc_resultsのルーティング
        Route::resource('gc_results', GcResultController::class);
        Route::post('gc_upload', [GcResultController::class, 'upload'])->name('gc_upload');

        // // gc_questionsのルーティング
        Route::post('/searchGc', [GcQuestionController::class, 'store'])->name('searchGc');
        Route::get('/gc_response/{id}', [GcQuestionController::class, 'response'])->name('gc_response');
        Route::post('/gc_responseAgain', [GcFollowUpController::class, 'askAgain'])->name('askAgainGc');

        // HPLC関連のルートに認証を適用
        Route::get('/gcs/top', function () {
            return view('gcs.top');
        })->name('gcTop');

        Route::get('/gcs/request', function () {
            return view('gcs.request');
        })->name('gcRequest');

        Route::get('/gcs/question', function () {
            return view('gcs.question');
        })->name('gcQuestion');

        Route::get('/gcs/response', function () {
            return view('gcs.response');
        })->name('gcResponse');

        Route::get('/gcs/record', function () {
            return view('gcs.record');
        });

        Route::get('/gcs/error', function () {
            return view('gcs.error');
        })->name('gcs.errorPage');

        // PNGデータの投稿
        Route::post('/convertGc/png', [GcResultController::class, 'convertPng'])->name('convertGc.png');

        // // gcs/watchで結果を見た後、requestに戻る場合（画像の削除も行う）
        Route::post('delete-and-redirectGc', [GcResultController::class, 'deleteAndRedirect'])->name('deleteAndRedirectGc');

        // // 自分の投稿を表示
        Route::get('/gcs/myPosts', [GcResultController::class, 'index'])->name('gcMyPosts');

        // // 投稿詳細表示
        Route::get('/gcs/myPosts/{id}', [GcResultController::class, 'show'])->name('gcChooseData');

        // // 投稿の更新
        Route::put('/gcs/myPosts/{gc_result}', [GcResultController::class, 'update'])->name('gcUpdateData');

        // // 投稿の削除
        Route::delete('/gcs/myPosts/{gc_result}', [GcResultController::class, 'destroy'])->name('gcDestroyData');

        // // HPLCの記録を表示
        Route::get('/gcs/record', [GcRecordController::class, 'index'])->name('gcRecord');

        // // API関係のルーティング
        Route::get('api/department-countGc', [GcRecordController::class, 'departmentCount'])->name('api.departmentCountGc');
        Route::get('api/personal-statsGc', [GcRecordController::class, 'personalStats'])->name('api.personalStatsGc');

});

require __DIR__.'/auth.php'; // 認証関連のルートを読み込む 

