<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use App\Models\Post;
use App\Helpers\Helper;

class AdminController extends Controller
{

    public function index()
    {
        $users = User::all(); // Or paginate, filter, etc.
        return view('admin.users.index', compact('users'));
    }
    public function dashboard()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.dashboard', compact('users'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        Helper::deleteUserAssets($user);
    }

    public function show($id)
    {
        $user = User::with('posts')->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function showPost($id)
    {
        // Load post with related user, likes, and comments (with their users)
        $post = Post::with(['user', 'likes', 'comments.user'])->findOrFail($id);

        return view('admin.posts.show', compact('post'));
    }
    public function Commentdestroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }

    public function Likedestroy($id)
    {
        $like = Like::findOrFail($id);
        $like->delete();
        return redirect()->back()->with('success', 'Like removed successfully.');
    }

}