@extends('layouts.sidebar')

@section('content')
<!-- <p class="content_name">ユーザー検索</p> -->
<div class="search_content w-100 d-flex">
      <div class="reserve_users_area">
            @foreach($users as $user)
            <div class="border one_person content">
                  <div>
                        <span class="gray">ID : </span><span class="more_gray">{{ $user->id }}</span>
                  </div>
                  <div class="user_profile"><span class="gray">名前 : </span>
                        <a href="{{ route('user.profile', ['id' => $user->id]) }}">
                              <span class="more_gray">{{ $user->over_name }} {{ $user->under_name }}</span>
                              <!-- <span>{{ $user->under_name }}</span> -->
                        </a>
                  </div>
                  <div>
                        <span class="gray">カナ : </span>
                        <span class="more_gray">({{ $user->over_name_kana }} {{ $user->under_name_kana }})</span>
                        <!-- <span>{{ $user->under_name_kana }})</span> -->
                  </div>
                  <div>
                        @if($user->sex == 1)
                        <span class="gray">性別 : </span><span class="more_gray">男</span>
                        @elseif($user->sex == 2)
                        <span class="gray">性別 : </span><span class="more_gray">女</span>
                        @else
                        <span class="gray">性別 : </span><span class="more_gray">その他</span>
                        @endif
                  </div>
                  <div>
                        <span class="gray">生年月日 : </span><span class="more_gray">{{ $user->birth_day }}</span>
                  </div>
                  <div>
                        @if($user->role == 1)
                        <span class="gray">権限 : </span><span class="more_gray">教師(国語)</span>
                        @elseif($user->role == 2)
                        <span class="gray">権限 : </span><span class="more_gray">教師(数学)</span>
                        @elseif($user->role == 3)
                        <span class="gray">権限 : </span><span class="more_gray">講師(英語)</span>
                        @else
                        <span class="gray">権限 : </span><span class="more_gray">生徒</span>
                        @endif
                  </div>
                  <div>
                        @if($user->role == 4)
                        <span class="gray">選択科目 :</span>
                        <!-- 追加 -->
                        @foreach($user->subjects as $subject)
                        <span class="more_gray">{{ $subject->subject }}</span>
                        @endforeach
                        @endif
                  </div>
            </div>
            @endforeach
      </div>

      <!-- 検索 -->
      <div class="search_area w-25 ">
            <div class="search_form_content">
                  <div class="search_form">
                        <label>検索</label>
                        <input type="text" class="free_word" name="keyword" placeholder="キーワードを検索" form="userSearchRequest">
                  </div>
                  <di class="user_category_form">
                        <label>カテゴリ</label>
                        <select form="userSearchRequest" name="category">
                              <option value="name">名前</option>
                              <option value="id">社員ID</option>
                        </select>
                  </di>
                  <div class="updown_form">
                        <label>並び替え</label>
                        <select name="updown" form="userSearchRequest">
                              <option value="ASC">昇順</option>
                              <option value="DESC">降順</option>
                        </select>
                  </div>
                  <div class="search_conditions_form">
                        <p class="m-0 search_criteria_addition"><label>検索条件の追加</label></p>

                        <button type="button" class="search_list_btn">
                              <span class="inn"></span>
                        </button>

                        <div class="search_conditions_inner">
                              <div class="sex_form">
                                    <label>性別</label>
                                    <div class="sex_form_list">
                                          <span>男</span><input type="radio" name="sex" value="1" form="userSearchRequest">
                                          <span>女</span><input type="radio" name="sex" value="2" form="userSearchRequest">
                                          <span>その他</span><input type="radio" name="sex" value="3" form="userSearchRequest">
                                    </div>
                              </div>
                              <div class="role_form">
                                    <label>権限</label>
                                    <select name="role" form="userSearchRequest" class="engineer">
                                          <option selected disabled>----</option>
                                          <option value="1">教師(国語)</option>
                                          <option value="2">教師(数学)</option>
                                          <option value="3">教師(英語)</option>
                                          <option value="4" class="">生徒</option>
                                    </select>
                              </div>
                              <div class="selected_engineer">
                                    <label>選択科目</label>
                                    <!-- 追加 -->
                                    <div class="subject_form">
                                          @foreach($subjects as $subject)
                                          <div class="subject_form_list">
                                                <label>{{ $subject->subject }}</label>
                                                <input type="checkbox" name="subject[]" value="{{ $subject->id }}" form="userSearchRequest">
                                          </div>
                                          @endforeach
                                    </div>
                              </div>
                        </div>
                  </div>
                  <div class="search_form_btn">
                        <input type="submit" name="search_btn" value="検索" form="userSearchRequest">

                        <!-- <button type="button" class="search_form_btn"><input type="submit" name="search_btn" value="検索" form="userSearchRequest"></button> -->
                  </div>
                  <div class="reset_btn">
                        <input type="reset" value="リセット" form="userSearchRequest">
                  </div>
            </div>
            <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
      </div>
</div>
@endsection