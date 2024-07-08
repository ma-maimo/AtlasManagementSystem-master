<?php

namespace App\Searchs;

use App\Models\Users\User;

class AllUsers implements DisplayUsers
{

  // 科目が選択されていない時のすべてのユーザー検索
  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects)
  {
    $users = User::all();
    return $users;
  }
}