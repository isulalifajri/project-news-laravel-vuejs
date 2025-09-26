<?php

namespace App\Services;

use App\Models\Post;

class PostService
{
    
    public function transformPost(Post $post): array
    {
        return [
            'id'       => $post->id,
            'image'    => $post->thumbnail
                            ? asset('storage/' . $post->thumbnail)
                            : "https://picsum.photos/800/400?random=" . rand(1, 1000),
            'category' => $post->category?->name ?? 'GENERAL',
            'catSlug'  => $post->category?->slug ?? '#',
            'title'    => $post->title,
            'author'   => $post->backendUser?->name ?? 'Unknown',
            'date'     => $post->published_at?->format('M d, Y'),
            'slug'     => $post->slug,
        ];
    }
}
