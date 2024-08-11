@extends('layouts.sidebar')

@section('content')
<!-- <p class="w-75 m-auto content_name">投稿一覧</p> -->
<div class="board_area w-100 border m-auto d-flex">
      <div class="post_view w-75 mt-5">
            @foreach($posts as $post)
            <div class="post_area border w-75 m-auto p-3">

                  <p class="post_name"><span>{{ $post->user->over_name }}</span><span class="ml-1">{{ $post->user->under_name }}</span>さん</p>
                  <p class="post_title"><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>
                  <div class="post_bottom_area d-flex">
                        <div class="d-flex post_status">

                              @foreach($post->subCategories as $subCategory)
                              <input type="submit" name="" class="category_btn" value="{{ $subCategory->sub_category }}">
                              @endforeach

                              <div class="action d-flex">
                                    <!-- コメント -->
                                    <div class="mr-5">
                                          <i class="fa fa-comment"></i><span class="counts">{{ (Auth::user()->is_Comment($post->id)) }}</span>
                                    </div>

                                    <!-- いいね -->
                                    <div>
                                          @if(Auth::user()->is_Like($post->id))
                                          <p class="m-0"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }} counts">{{ $post->likes()->count()}}</span></p>
                                          @else
                                          <p class="m-0"><i class="far fa-heart like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }} counts">{{ $post->likes()->count()}}</span></p>
                                          @endif
                                    </div>
                              </div>

                        </div>
                  </div>
            </div>
            @endforeach
      </div>
      <div class="other_area">
            <div class="mt-5">
                  <div class="post_btn"><a href="{{ route('post.input') }}">投稿</a></div>

                  <!-- 検索 -->
                  <div class="">
                        <form action="{{ route('post.show') }}" method="GET">
                              @csrf
                              <div class="d-flex search">
                                    <input type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest" value="{{ request('search_term') }}">
                                    <input type="submit" value="検索" form="postSearchRequest">
                              </div>
                        </form>

                        <div class="d-flex">
                              <input type="submit" name="like_posts" class="like_post_btn" value="いいねした投稿" form="postSearchRequest">
                              <input type="submit" name="my_posts" class="my_post_btn" value="自分の投稿" form="postSearchRequest">
                        </div>


                        <p class="category_search">カテゴリー検索</p>
                        <ul class="search_list">
                              @foreach($categories as $category)
                              <li class="main_categories" category_id="{{ $category->id }}">
                                    <span class="main_category">{{ $category->main_category }}</span>

                                    <button type="button" class="category_search_list_btn">
                                          <span class="inn"></span>
                                    </button>

                                    <ul class="category_num{{ $category->id }} category-content">
                                          @foreach($category->subCategories as $sub_category)
                                          <li class="sub_categories_search" value="{{ $sub_category->id }}" name="select_sub_category">
                                                <a href="{{ route('post.subcategory', ['id' => $sub_category->id]) }}">{{ $sub_category->sub_category }}</a>
                                          </li>
                                          @endforeach
                                    </ul>
                              </li>
                              @endforeach
                        </ul>
                  </div>
            </div>
            <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
      </div>
      @endsection