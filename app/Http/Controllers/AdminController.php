<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    // 認証ミドルウェアを適用
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // すべてのユーザーを取得
        $users = User::paginate(10);

        // ビューにデータを渡す
        return view('userAdmin', compact('users'));
    }
}
