<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

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
        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
        }
        $posts = Post::where('user_id', $user->id)->get();
        foreach ($posts as $post) {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
        }
        Post::where('user_id', $user->id)->delete();
        $user->delete();
        return back()->with('success', 'User, their profile photo, and all post images deleted successfully.');
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