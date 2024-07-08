<?php

namespace App\Http\Controllers\Authenticated\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Gate;
use App\Models\Users\User;
use App\Models\Users\Subjects;
use App\Searchs\DisplayUsers;
use App\Searchs\SearchResultFactories;

class UsersController extends Controller
{

    public function showUsers(Request $request)
    {
        // リクエストから検索条件を取得
        $keyword = $request->keyword;
        $category = $request->category;
        $updown = $request->updown;
        $gender = $request->sex;
        $role = $request->role;
        $subjects = $request->input('subject'); // ここで検索時の科目を受け取る

        // dd($request);

        // ユーザー検索用のファクトリクラスのインスタンスを作成
        $userFactory = new SearchResultFactories();

        // 検索条件に基づいてユーザーを取得
        $users = $userFactory->initializeUsers($keyword, $category, $updown, $gender, $role, $subjects);
        // dd($users);

        // すべての科目データを取得
        $subjects = Subjects::all();

        // 'authenticated.users.search' ビューにユーザーと科目のデータを渡す
        return view('authenticated.users.search', compact('users', 'subjects'));
    }

    public function userProfile($id)
    {
        $user = User::with('subjects')->findOrFail($id);
        $subject_lists = Subjects::all();
        return view('authenticated.users.profile', compact('user', 'subject_lists'));
    }

    public function userEdit(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->subjects()->sync($request->subjects);
        return redirect()->route('user.profile', ['id' => $request->user_id]);
    }
}