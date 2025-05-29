<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $post->update($request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]));

        return redirect()->route('admin.dashboard')->with('success', 'Post updated');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return back()->with('success', 'Post deleted');
    }
}
