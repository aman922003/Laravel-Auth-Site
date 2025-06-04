<?php

namespace App\Helpers;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class Helper
{
    public static function deleteUserAssets($user)
    {
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
        return back()->with('success', 'User and all associated assets deleted successfully.');
    }

    public static function deletePostAssets($post)
    {
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }
    }

}