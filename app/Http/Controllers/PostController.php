<?php

// app/Http/Controllers/PostController.php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        // $posts = Auth::user()->posts;
        // $posts = Post::all();
        $posts = Post::with('user')->latest()->paginate(6); // 6 posts per page
        return view('posts.index', compact('posts'));
    }

    public function toggleLike(Request $request, $postId)
    {
        $post = Post::findOrFail($postId);
        $user = Auth::user();
        $like = $post->likes()->where('user_id', $user->id)->first();
        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            $post->likes()->create(['user_id' => $user->id]);
            $liked = true;
        }
        return response()->json([
            'liked' => $liked,
            'likes_count' => $post->likes()->count()
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function show($id)
    {
        // $post = Post::findOrFail($id);
        // $like = Like::all($id);
        $post = Post::with(['user', 'comments.user', 'likes'])->findOrFail($id);
        return view('posts.show', ['post' => $post]);
        // return view('posts.show', ['like' => $like]);

    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|max:5000'
        ]);
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }
        Auth::user()->posts()->create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
        ]);
        return redirect()->route('posts.index')->with('success', 'Post created');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $post->title = $request->title;
        $post->content = $request->content;
        if ($request->hasFile('image')) {
            Helper::deletePostAssets($post);
            $path = $request->file('image')->store('uploads', 'public');
            $post->image = $path;
        }
        $post->save();
        return redirect()->route('posts.index')->with('success', 'Post updated');
    }

    public function destroy(POST $post)
    {
        Helper::deletePostAssets($post); // Delete Post image from storage.
        $post->delete();
        return back()->with('success', 'Post deleted');
    }

    public function toggleSave(Post $post)
    {
        $user = auth()->user();
        if ($user->savedPosts->contains($post->id)) {
            $user->savedPosts()->detach($post->id);
        } else {
            $user->savedPosts()->attach($post->id);
        }

        return back();
    }

    public function storeComment(Request $request)
    {

        $request->validate([
            'content' => 'required|string|max:1000',
            'post_id' => 'required|exists:posts,id',
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $request->post_id,
            'parent_id' => $request->parent_id, // nullable for top-level comments
            'content' => $request->content,
        ]);
        return redirect()->route('posts.show', $request->post_id)->with('success', 'Comment added!');
    }
}