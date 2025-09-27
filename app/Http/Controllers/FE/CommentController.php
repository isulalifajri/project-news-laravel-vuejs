<?php

namespace App\Http\Controllers\FE;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        $comment->load('user'); // biar ada user + avatar

        return response()->json([
            'message' => 'Komentar berhasil ditambahkan',
            'comment' => [
                'id' => $comment->id,
                'author' => $comment->user->name,
                'avatar' => $comment->user->avatar,
                'content' => $comment->content,
                'likes_count' => 0,
                'is_liked' => false,
            ],
        ]);
    }


    public function toggleLike(Comment $comment)
    {
        $user = auth()->user();

        if ($comment->likes()->where('user_id', $user->id)->exists()) {
            $comment->likes()->where('user_id', $user->id)->delete();
            $isLiked = false;
        } else {
            $comment->likes()->create(['user_id' => $user->id]);
            $isLiked = true;
        }

        return response()->json([
            'is_liked' => $isLiked,
            'likes_count' => $comment->likes()->count(),
        ]);
    }
}
