@extends('layouts.sidebar')

@section('content')
<div class="post_create_container d-flex">
      <div class="post_create_area border mt-5 ml-5 mb-5 p-5">
            <div class="category_select">
                  @if($errors->first('post_category_id'))
                  <span class="error_message">{{ $errors->first('post_category_id') }}</span>
                  @endif
                  <p class="mb-0">カテゴリー</p>
                  <select class="w-100" form="postCreate" name="sub_category_ids[]">
                        <!-- <option>-----</option> -->
                        @foreach($main_categories as $main_category)
                        <optgroup label="{{ $main_category->main_category }}">
                              <!-- サブカテゴリー表示 -->
                              @foreach($main_category->subCategories as $sub_category)
                              <option value="{{ $sub_category->id }}" name="sub_category_id">{{ $sub_category->sub_category }}</option>
                              @endforeach
                        </optgroup>
                        @endforeach
                  </select>
            </div>

            <div class="mt-3 title_form">
                  @if($errors->first('post_title'))
                  <span class="error_message">{{ $errors->first('post_title') }}</span>
                  @endif
                  <p class="mb-0">タイトル</p>
                  <input type="text" class="w-100" form="postCreate" name="post_title" value="{{ old('post_title') }}">
            </div>

            <div class="mt-3 post_form">
                  @if($errors->first('post_body'))
                  <span class="error_message">{{ $errors->first('post_body') }}</span>
                  @endif
                  <p class="mb-0">投稿内容</p>
                  <textarea class="w-100" form="postCreate" name="post_body">{{ old('post_body') }}</textarea>
            </div>

            <div class="mt-3 text-right">
                  <input type="hidden" name="post_id" value="{{ '$post_id' }}">
                  <input type="submit" class="btn btn-primary" value="投稿" form="postCreate">
            </div>

            <form action="{{ route('post.create') }}" method="post" id="postCreate">{{ csrf_field() }}</form>
      </div>
      @can('admin')

      <div class="w-25">
            <div class="category_area mt-5 p-5 border">
                  <div class="main_category_area">
                        @if ($errors->has('main_category_name'))
                        <span class="text-danger">{{ $errors->first('main_category_name') }}</span>
                        @endif
                        <p class="m-0">メインカテゴリー</p>
                        <input type="text" class="w-100" name="main_category_name" form="mainCategoryRequest">
                        <input type="submit" value="追加" class="w-100 btn btn-primary p-0" form="mainCategoryRequest">
                  </div>
                  <form action="{{ route('main.category.create') }}" method="post" id="mainCategoryRequest">{{ csrf_field() }}</form>

                  <!-- サブカテゴリー追加 -->
                  <div class="sub_category_area">
                        <ul>
                              <li> @if ($errors->has('main_category_id'))
                                    <span class="text-danger">{{ $errors->first('main_category_id') }}</span>
                                    @endif
                              </li>
                              <li> @if ($errors->has('sub_category_name'))
                                    <span class="text-danger">{{ $errors->first('sub_category_name') }}</span>
                                    @endif
                              </li>
                        </ul>
                        <p class="m-0">サブカテゴリー</p>
                        <select class="" name="main_category_id" form="subCategoryRequest">
                              <option>----</option>
                              @foreach($main_categories as $main_category)
                              <option value="{{ $main_category->id }}" name="main_category_id">{{ $main_category->main_category }}</option>
                              @endforeach
                        </select>

                        <input type="text" class="w-100" name="sub_category_name" form="subCategoryRequest">
                        <input type="hidden" name="sub_category_id" form="subCategoryRequest" value="{{ $main_category->subCategories }}">
                        <input type="submit" value="追加" class="w-100 btn btn-primary p-0" form="subCategoryRequest">
                  </div>
                  <form action="{{ route('sub.category.create') }}" method="post" id="subCategoryRequest">{{ csrf_field() }}</form>
            </div>
      </div>
      @endcan
</div>
@endsection