@extends('layouts.sidebar')

@section('content')
<!-- スクール予約詳細画面 -->
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
      <div class="m-auto h-75 detail_container">
            <p class="mb-2"><span>{{ \Carbon\Carbon::parse($date)->format('Y年m月d日') }}</span><span class="ml-3">{{ $part }}部</span></p>
            <div class="w-100 reserve_setting_detail">
                  <table class="w-100">
                        <tr class="text-center colum">
                              <th class="colum_name">ID</th>
                              <th class="colum_name">名前</th>
                              <th class="colum_name">場所</th>
                        </tr>
                        @foreach($reservePersons as $reservePerson)
                        @foreach($reservePerson->users as $user)
                        <tr class="text-center detail_content">
                              <td>{{ $user->id }}</td>
                              <td>{{ $user->over_name }}{{ $user->under_name }}</td>
                              <td>リモート</td>
                        </tr>
                        @endforeach
                        @endforeach
                  </table>
            </div>
      </div>
</div>
@endsection