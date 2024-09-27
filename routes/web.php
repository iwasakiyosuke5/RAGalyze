<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HplcResultController;
use App\Http\Controllers\HplcQuestionController;
Use App\Http\Controllers\HplcFollowUpController;
use App\Http\Controllers\HplcRecordController;
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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // hplc_resultsのルーティング
    Route::resource('hplc_results', HplcResultController::class);
    Route::post('hplc_upload', [HplcResultController::class, 'upload'])->name('hplc_upload');


    // hplc_questionsのルーティング
    Route::post('/search', [HplcQuestionController::class, 'store'])->name('search');
    Route::get('/hplc_response/{id}', [HplcQuestionController::class, 'response'])->name('hplc_response');
    Route::post('/hplc_responseAgain', [HplcFollowUpController::class, 'askAgain'])->name('askAgain');
    

});

require __DIR__.'/auth.php';



// HPLC関係
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

    //さらにpngデータの投稿
    Route::post('/convert/png', [HplcResultController::class, 'convertPng'])->name('convert.png'); 

    // hplcs/watchで結果を見た後、requestに戻る場合（画像の削除も行う）
    Route::post('delete-and-redirect', [HplcResultController::class, 'deleteAndRedirect'])->name('deleteAndRedirect');

    // hplcs/myPosts.blade.phpの表示
    Route::get('/hplcs/myPosts', [HplcResultController::class, 'index'])->name('hplcMyPosts');

    // hplcs/myPosts.blade.phpのからの詳細表示
    Route::get('/hplcs/myPosts/{id}', [HplcResultController::class, 'show'])->name('hplcChooseData');

    // hplcs/myPosts.blade.phpのからの更新
    Route::put('/hplcs/myPosts/{hplc_result}', [HplcResultController::class, 'update'])->name('hplcUpdateData');

    // hplcs/myPosts.blade.phpのからの削除
    Route::delete('/hplcs/myPosts/{hplc_result}', [HplcResultController::class, 'destroy'])->name('hplcDestroyData');

    

    Route::get('/hplcs/record', [HplcRecordController::class, 'index'])->name('hplcRecord');

    Route::get('api/department-count', [HplcRecordController::class, 'departmentCount'])->name('api.departmentCount');
    Route::get('api/personal-stats', [HplcRecordController::class, 'personalStats'])->name('api.personalStats');