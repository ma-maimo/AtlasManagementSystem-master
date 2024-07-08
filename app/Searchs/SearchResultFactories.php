<?php

namespace App\Searchs;

use App\Models\Users\User;

class SearchResultFactories
{

  // 改修課題：選択科目の検索機能
  public function initializeUsers($keyword, $category, $updown, $gender, $role, $subjects)
  {
    if ($category == 'name') { // 科目が指定されていない場合、名前検索用のクラスをインスタンス化
      if (is_null($subjects)) {
        $searchResults = new SelectNames(); //SelectNames クラスをインスタンス化して名前で検索。
      } else { // 科目が指定されている場合、詳細な名前検索用のクラスをインスタンス化
        $searchResults = new SelectNameDetails(); //SelectNameDetails クラスをインスタンス化して詳細な名前で検索。
      }
      return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $subjects); //検索処理
    } else if ($category == 'id') {
      if (is_null($subjects)) { // 科目が指定されていない場合、ID検索用のクラスをインスタンス化
        $searchResults = new SelectIds(); //SelectIds クラスをインスタンス化してIDで検索。
      } else { // 科目が指定されている場合、詳細なID検索用のクラスをインスタンス化
        $searchResults = new SelectIdDetails(); //SelectIdDetails クラスをインスタンス化して詳細なIDで検索。
      }
      return $searchResults->resultUsers($keyword, $category, $updown, $gender, $role, $subjects); //検索処理
    } else { // カテゴリが指定されていない場合、全ユーザーを対象とする検索クラスをインスタンス化
      $allUsers = new AllUsers(); //AllUsers クラスをインスタンス化して、すべてのユーザーを対象に検索
      return $allUsers->resultUsers($keyword, $category, $updown, $gender, $role, $subjects); //検索処理
    }
  }
}