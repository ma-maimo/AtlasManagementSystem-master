@extends('layouts.sidebar')

@section('content')
<div class="">
      <div class="top_area w-75 m-auto pt-5">
            <span>{{ $user->over_name }}</span><span>{{ $user->under_name }}さんのプロフィール</span>
            <div class="user_status p-3">
                  <p>名前 : <span>{{ $user->over_name }}</span><span class="ml-1">{{ $user->under_name }}</span></p>
                  <p>カナ : <span>{{ $user->over_name_kana }}</span><span class="ml-1">{{ $user->under_name_kana }}</span></p>
                  <p>性別 : @if($user->sex == 1)<span>男</span>@else<span>女</span>@endif</p>
                  <p>生年月日 : <span>{{ $user->birth_day }}</span></p>
                  <div>選択科目 :
                        @foreach($user->subjects as $subject)
                        <span>{{ $subject->subject }}</span>
                        @endforeach
                  </div>
                  <div class="select_subject_list">
                        @can('admin')
                        <span class="optional_subject_register">選択科目の登録</span>

                        <button type="button" class="select_subject_list_btn">
                              <span class="inn"></span>
                        </button>

                        <div class="subject_inner">
                              <form action="{{ route('user.edit') }}" method="post">
                                    <!-- @foreach($subject_lists as $subject_list)
                                    <div>
                                          <label>{{ $subject_list->subject }}</label>
                                          <input type="checkbox" name="subjects[]" value="{{ $subject_list->id }}">
                                    </div>
                                    @endforeach -->

                                    <div class="subject_select_form">

                                          <div class="subject_form">
                                                @foreach($subject_lists as $subject_list)
                                                <div class="subject_form_list">
                                                      <label>{{ $subject_list->subject }}</label>
                                                      <!-- <input type="checkbox" name="subjects[]" value="{{ $subject_list->id }}"> -->
                                                      <input type="checkbox" name="subjects[]" value="{{ $subject_list->id }}" @if(in_array($subject_list->id,$user_subjects)) checked @endif>
                                                </div>
                                                @endforeach
                                          </div>



                                          <div class="subject_registration">
                                                <input type="submit" value="登録" class="btn btn-primary">
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                {{ csrf_field() }}
                                          </div>
                                    </div>
                              </form>
                        </div>
                        @endcan
                  </div>
            </div>
      </div>
</div>

@endsection
