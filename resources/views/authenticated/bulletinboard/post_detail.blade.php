@extends('layouts.sidebar')
@section('content')
<div class="d-flex">
      <div class="w-50 mt-5">
            <div class="m-3 detail_container w-100">
                  <div class="edit_error pl-3">
                        <ul>
                              <li> @if($errors->first('post_title'))
                                    <span class="error_message">{{ $errors->first('post_title') }}</span>
                                    @endif
                              </li>
                              <li> @if($errors->first('post_body'))
                                    <span class="error_message">{{ $errors->first('post_body') }}</span>
                                    @endif
                              </li>
                        </ul>
                  </div>
                  <div class="p-3 edit_area">
                        <div class="detail_inner_head">
                              @if(Auth::user() == $post->user )
                              <div class="detail_btn">
                                    <span class="edit-modal-open btn btn-primary edit_btn" post_title="{{ $post->post_title }}" post_body="{{ $post->post }}" post_id="{{ $post->id }}">編集</span>
                                    <a href="{{ route('post.delete', ['id' => $post->id]) }}" onclick="return confirm('削除してよろしいですか？')"><button type="button" class="btn btn-danger post_delete">削除</button></a>
                              </div>
                              @endif
                        </div>


                        @foreach($post->subCategories as $subCategory)
                        <input type="submit" name="" class="category_btn" value="{{ $subCategory->sub_category }}">
                        @endforeach



                        <div class="contributor d-flex">
                              <p class="edit_name">
                                    <span>{{ $post->user->over_name }}</span>
                                    <span>{{ $post->user->under_name }}</span>
                                    さん
                              </p>
                              <!-- <span class="ml-5">{{ $post->created_at }}</span> -->
                        </div>
                        <div class="detail_post_title">{{ $post->post_title }}</div>
                        <div class="detail_post">{{ $post->post }}</div>
                  </div>
                  <div class="p-3 comment_wrapper">
                        <div class="comment_container">
                              <span class="">コメント</span>
                              @foreach($post->postComments as $comment)
                              <div class="comment_area">
                                    <p class="comment_name">
                                          <span>{{ $comment->commentUser($comment->user_id)->over_name }}</span>
                                          <span>{{ $comment->commentUser($comment->user_id)->under_name }}</span>さん
                                    </p>
                                    <p class="comment">{{ $comment->comment }}</p>
                              </div>
                              @endforeach
                        </div>
                  </div>
            </div>
      </div>
      <div class="w-50 p-3">
            <div class="comment_container border m-5">
                  <div class="comment_area p-3">
                        <div class="comment_error">
                              @if ($errors->has('comment'))
                              <span class="text-danger">{{ $errors->first('comment') }}</span>
                              @endif
                        </div>
                        <p class="m-0">コメントする</p>
                        <textarea class="w-100" name="comment" form="commentRequest"></textarea>
                        <input type="hidden" name="post_id" form="commentRequest" value="{{ $post->id }}">
                        <input type="submit" class="btn btn-primary comment_btn" form="commentRequest" value="投稿">
                        <form action="{{ route('comment.create') }}" method="post" id="commentRequest">{{ csrf_field() }}</form>
                  </div>
            </div>
      </div>
</div>

<!-- モーダル -->
<div class="modal js-modal ">
      <div class="modal__bg js-modal-close"></div>
      <div class="modal__content">
            <form action="{{ route('post.edit') }}" method="post">
                  <div class="w-100">
                        <div class="modal-inner-title m-auto">
                              <input type="text" name="post_title" value="{{ old('post_title') }}" placeholder="タイトル" class="w-100">
                        </div>

                        <div class="modal-inner-body m-auto pt-3 pb-3">
                              <textarea placeholder="投稿内容" name="post_body" class="w-100">{{ old('post_body') }}</textarea>
                        </div>

                        <div class="w-50 m-auto edit-modal-btn d-flex">
                              <a class="js-modal-close btn btn-danger d-inline-block modal_close_btn" href="">閉じる</a>
                              <input type="hidden" class="edit-modal-hidden" name="post_id" value="{{ old('post_id') }}">
                              <input type="submit" class="btn btn-primary d-block modal_edit_btn" value="編集">
                        </div>
                  </div>
                  {{ csrf_field() }}
            </form>
      </div>
</div>
@endsection
