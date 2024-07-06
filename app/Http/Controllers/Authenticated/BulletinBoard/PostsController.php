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
        $posts = Post::with('user', 'postComments')->get()->sortByDesc('updated_at');
        $categories = MainCategory::get();
        $like = new Like;
        $post_comment = new Post;
        if (!empty($request->keyword)) {
            $posts = Post::with('user', 'postComments')
                ->where('post_title', 'like', '%' . $request->keyword . '%')
                ->orWhere('post', 'like', '%' . $request->keyword . '%')->get();
        } else if ($request->category_word) {
            $sub_category = $request->category_word;
            $posts = Post::with('user', 'postComments')->get();
        } else if ($request->like_posts) {
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with('user', 'postComments')
                ->whereIn('id', $likes)->get();
        } else if ($request->my_posts) {
            $posts = Post::with('user', 'postComments')
                ->where('user_id', Auth::id())->get();
        }

        // 新しい順にソート
        $posts = $posts->sortByDesc('updated_at');

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
    }


    // 追加：検索
    public function searchView(Request $request)
    {
        $keyword = $request->input('keyword'); //検索ワードの取得
        // dd($keyword);
        $query = Post::query(); //ユーザー名に検索ワードが含まれているユーザーを検索

        if (isset($keyword)) { //検索ワードが存在する場合
            //検索クエリでユーザー名が検索キーワードを含むかどうか
            $query->where('post_title', 'like', '%' . $keyword . '%')->get();
            //検索結果に当てはまるユーザーを全件取得、作成日時で降順、20件ずつのページネーション
            $posts = $query->orderBy('created_at', 'desc')->paginate(20);
        } else { //検索キーワードが存在しない場合
            // すべてのユーザーを作成日時の降順で取得、20件ずつのページネーション
            $posts = $query->orderBy('created_at', 'desc')->paginate(20);
        }
        // dd($data);
        // 検索キーワード、ユーザーの検索結果、クエリ、およびリダイレクトフラグをビューに渡す
        return view('posts.search', [
            'keyword' => $keyword,
            'posts' => $posts,
            'query' => $query,
            'redirect_to_search' => true,
        ]);
    }
}