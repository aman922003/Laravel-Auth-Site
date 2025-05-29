<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
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

// public function edit(Comment $comment)
// {
//     $this->authorize('update', $comment);
//     return view('comments.edit', compact('comment'));
// }

// public function update(Request $request, Comment $comment)
// {
//     $this->authorize('update', $comment);   
//     $request->validate(['content' => 'required|string|max:1000']);
//     $comment->update(['content' => $request->content]);
//     return redirect()->route('posts.show', $comment->post_id)->with('success', 'Comment updated!');
// }

}