<?php

namespace App\Http\Controllers\FE;

use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $slides = Post::where('status', 'published')
            ->inRandomOrder()        // 👈 biar acak setiap refresh
            ->take(5)
            ->with(['category', 'backendUser'])
            ->get()
            ->map(function ($post) {
                return [
                    'image'    => $post->thumbnail
                                    ? asset('storage/' . $post->thumbnail)
                                    : "https://picsum.photos/800/400?random=" . rand(1, 1000),
                    'category' => $post->category?->name ?? '-',
                    'title'    => $post->title,
                    'author'   => $post->backendUser?->name ?? 'Unknown',
                    'date'     => $post->published_at?->format('M d, Y'),
                    'slug'     => $post->slug,
                ];
            });

        // --- Right Cards (2 post populer/random kalau tidak ada views) ---
        $rightCards = Post::where('status', 'published')
            ->orderByDesc('views')    // pakai views kalau ada
            ->take(2)
            ->with(['category', 'backendUser'])
            ->get()
            ->map(function ($post) {
                return [
                    'image'    => $post->thumbnail
                                    ? asset('storage/' . $post->thumbnail)
                                    : "https://picsum.photos/400/200?random=" . rand(1, 1000),
                    'category' => $post->category?->name ?? '-',
                    'title'    => $post->title,
                    'author'   => $post->backendUser?->name ?? 'Unknown',
                    'date'     => $post->published_at?->format('M d, Y'),
                    'slug'     => $post->slug,
                ];
            });

        // Trending News (ditandai is_featured)
        $trending = Post::where('status', 'published')
            ->where(function ($query) {
                $query->where('is_featured', true)
                    ->orWhere('published_at', '>=', now()->subDays(7));
            })
            ->orderByDesc('views') // urutkan berdasarkan views
            ->latest('published_at') // kalau views sama, urutkan tanggal terbaru
            ->take(5)
            ->get();

        // Most Popular (berdasarkan views terbanyak)
        $mostPopular = Post::where('status', 'published')
            ->orderByDesc('views')
            ->take(5)
            ->get();

        // Latest Posts (berdasarkan tanggal publish terbaru)
        $latest = Post::where('status', 'published')
            ->latest('published_at')
            ->take(6)
            ->get();

        return Inertia::render('Home', [
            'trending'     => $trending,
            'mostPopular'  => $mostPopular,
            'latest'       => $latest,
            'slides'       => $slides,
            'rightCards'   => $rightCards,
        ]);
    }
}
