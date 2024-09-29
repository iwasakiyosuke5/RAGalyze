<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // 編集ページを表示
    public function edit($id)
    {
        $user = User::findOrFail($id); // 該当するユーザーを取得
        return view('userEdit', compact('user'));
    }

    // ユーザー情報を更新
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // 入力データのバリデーション
        $request->validate([
            'position' => 'required|string',
            'department' => 'required|string',
        ]);

        // ユーザー情報を更新
        $user->update([
            'position' => $request->input('position'),
            'department' => $request->input('department'),
        ]);

        return redirect()->route('userAdmin')->with('success', 'ユーザー情報が更新されました。');
    }
}
