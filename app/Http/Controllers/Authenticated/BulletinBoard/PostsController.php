<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\PostSubCategory;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;

use Auth;
// use Illuminate\Support\Facades\Auth;


class PostsController extends Controller
{
    public function show(Request $request)
    {
        // $postId = 1;
        // // // 投稿が存在するか確認
        // $post = Post::find($postId);

        // $post->SubCategories;

        // // // // 投稿が関連するサブカテゴリーを取得
        // $postSubCategory = $post->postSubCategory;

        // // // サブカテゴリーが正しく設定されているか確認
        // // // $subCategory = $postSubCategory ? $postSubCategory->subCategory : null;
        // $subCategory = $postSubCategory->subCategory;

        // if ($subCategory) {
        //     echo $subCategory->sub_category;
        // } else {
        //     echo "サブカテゴリーが設定されていません";
        // }


        // dd($request->all());
        // 全部の投稿の取得と更新順にソート
        $posts = Post::with('postSubCategory.subCategory', 'user', 'postComments', 'likes')->get()->sortByDesc('updated_at');

        $categories = MainCategory::get();
        $like = new Like;
        $post_comment = new Post;

        // $post = Post::with('postSubCategory.subCategory')->find(1); // 適切なIDを指定
        // dd($post->postSubCategory, $post->postSubCategories->subCategory->sub_category);

        // dd($posts);
        // dd($request);
        // キーワード検索：もしリクエストに keyword パラメータが含まれている場合、投稿のタイトルまたは本文にそのキーワードを含む投稿を検索
        // if (!empty($request->keyword)) {
        //     $posts = Post::with('user', 'postComments')
        //         ->where('post_title', 'like', '%' . $request->keyword . '%')
        //         ->orWhere('post', 'like', '%' . $request->keyword . '%')->get();
        // } else if (!empty($request->category_word)) { //カテゴリーでのフィルタリング:もしリクエストに category_word パラメータが含まれている場合、そのカテゴリーに属する投稿を取得
        //     $sub_category = $request->category_word;
        //     $posts = Post::with('user', 'postComments')->whereHas('subCategories', function ($query) use ($sub_category) {
        //         $query->where('sub_category', $sub_category);
        //     })->get();

        $keyword = $request->input('keyword');

        if (!empty($keyword)) {
            $posts = Post::with('user', 'postComments')
                ->where(function ($query) use ($keyword) { //投稿の曖昧検索
                    $query->where('post_title', 'like', '%' . $keyword . '%')
                        ->orWhere('post', 'like', '%' . $keyword . '%');
                })
                ->orWhereHas('subCategories', function ($query) use ($keyword) { //サブカテゴリーの検索
                    $query->where('sub_category', 'like', '%' . $keyword . '%');
                })
                ->orWhereHas('user', function ($query) use ($keyword) { //ユーザー名の検索
                    $query->where('over_name', 'like', '%' . $keyword . '%')
                        ->orWhere('under_name', 'like', '%' . $keyword . '%')
                        ->orWhereRaw("concat(over_name, under_name) like ?", ['%' . $keyword . '%']);
                })
                ->get();
        } else if ($request->like_posts) { //いいねした投稿の表示:もしリクエストに like_posts パラメータが含まれている場合、現在ログインしているユーザーがいいねした投稿のみを表示
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with('user', 'postComments')
                ->whereIn('id', $likes)->get();
        } else if ($request->my_posts) { //自分の投稿の表示:もしリクエストに my_posts パラメータが含まれている場合、現在ログインしているユーザーの投稿のみを表示
            $posts = Post::with('user', 'postComments')
                ->where('user_id', Auth::id())->get();
        }
        // 新しい順にソート
        // $posts = $posts->sortByDesc('updated_at');

        // ビューへのデータ渡し:最後に、適切にフィルタリングされた投稿、カテゴリー情報、いいね情報、そして投稿コメント情報をビューに渡す
        return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'like', 'post_comment'));
    }

    public function postDetail($post_id)
    {
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    public function postInput() //カテゴリーをコレクトしてビューに返す
    {
        // $main_categories = MainCategory::get();
        // $sub_categories = SubCategory::get(); //追加
        // return view('authenticated.bulletinboard.post_create', compact('main_categories', 'sub_categories'));

        $main_categories = MainCategory::with('subCategories')->get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories'));
    }


    public function postCreate(PostFormRequest $request)
    {
        $post = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);

        $post->subCategories()->attach($request->sub_category_ids);

        return redirect()->route('post.show');
    }

    public function postEdit(PostFormRequest $request)
    {
        // dd($request);
        // Post::where('id', $request->post_id)->update([
        //     'post_title' => $request->post_title,
        //     'post' => $request->post_body,
        // ]);
        // return redirect()->route('post.detail', ['id' => $request->post_id]);

        $post = Post::where('id', $request->post_id)->first();

        if ($post) {
            $post->update([
                'post_title' => $request->post_title,
                'post' => $request->post_body,
            ]);
            return redirect()->route('post.detail', ['id' => $post->id]);
        }

        return redirect()->back()->withErrors(['post_id' => 'Invalid post ID']);
    }

    public function postDelete($id)
    {
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }

    public function mainCategoryCreate(PostFormRequest $request)
    {
        MainCategory::create(['main_category' => $request->main_category_name]);
        return redirect()->route('post.input');
    }

    // 追加
    public function subCategoryCreate(PostFormRequest $request)
    {
        // dd($request);
        SubCategory::create([
            'main_category_id' => $request->main_category_id,
            'sub_category' => $request->sub_category_name
        ]);
        return redirect()->route('post.input');
    }

    public function commentCreate(PostFormRequest $request)
    {
        // dd($request->all());
        // Log::info('PostCommentFormRequest data: ', $request->all());

        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function myBulletinBoard()
    {
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard()
    {
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    public function postLike(Request $request)
    {
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();

        return response()->json();
        // return redirect()->route(
        //     'authenticated.bulletinboard.post_like',
        //     compact('posts', 'like')
        // );
    }

    public function postUnLike(Request $request)
    {
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
            ->where('like_post_id', $post_id)
            ->delete();

        return response()->json();
        // return redirect()->route(
        //     'authenticated.bulletinboard.post_like',
        //     compact('posts', 'like')
        // );
    }

    // 追加：カテゴリーごとに投稿の表示
    public function postBySubCategory($id)
    {
        $categories = MainCategory::with('subCategories')->get();
        $subCategory = SubCategory::findOrFail($id);
        $posts = $subCategory->posts()->with('user', 'postComments')->get();

        return view('authenticated.bulletinboard.posts', compact('categories', 'subCategory', 'posts'));
    }
}