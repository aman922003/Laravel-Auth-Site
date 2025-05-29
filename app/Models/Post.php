<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'image', 'user_id'];

    // The author of the post
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // app/Models/Post.php
public function likes()
{
    return $this->hasMany(Like::class)->with('user');
}

public function isLikedBy($user)
{
    
 return $user ? $this->likes()->where('user_id', $user->id)->exists() : false;

}

public function comments()
{
    return $this->hasMany(Comment::class);
}

public function show($slug)
{
    $post = Post::where('slug', $slug)->firstOrFail();

    // Get latest 5 posts for the sidebar
    $recentPosts = Post::latest()->take(5)->get();

    return view('blog.details', compact('post', 'recentPosts'));
}

public function showPost($id)
{
    // Eager load user, likes, comments, and comment users
    $post = Post::with(['user', 'likes', 'comments.user'])->findOrFail($id);

    return view('admin.posts.show', compact('post'));
}
}