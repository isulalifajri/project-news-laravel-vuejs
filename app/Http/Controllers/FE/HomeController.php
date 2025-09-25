<?php

namespace App\Http\Controllers\FE;

use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\FooterContact;
use App\Models\CompanyProfile;
use App\Http\Controllers\Controller;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil data Company Profile (anggap cuma satu row)
        $companyProfile = CompanyProfile::first();

        if (!$companyProfile) {
            $companyProfile = new CompanyProfile([
                'name' => 'SKY NEWS',
                'about' => '',
                'logo' => 'https://picsum.photos/800/400?random=logo',
            ]);
        }

        // Ambil data Footer yang aktif
        $footerContacts = FooterContact::where('is_active', true)
        ->whereNull('icon')->get();

        $categories = Category::all();

        $sosmedIcons = FooterContact::where('is_active', true)
        ->whereNotNull('icon')->get();

        $slides = Post::where('status', 'published')
            ->inRandomOrder()
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
            ->take(5)
            ->with(['category', 'backendUser'])
            ->get()
            ->shuffle()
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
        $trendingNews = Post::where('status', 'published')
            ->where(function ($query) {
                $query->where('is_featured', true)
                    ->orWhere('published_at', '>=', now()->subDays(7));
            })
            ->orderByDesc('views') // urutkan berdasarkan views
            ->latest('published_at') // kalau views sama, urutkan tanggal terbaru
            ->with(['category', 'backendUser'])
            ->take(5)
            ->get()
            ->map(function ($post) {
                return [
                    'image'    => $post->thumbnail
                                    ? asset('storage/' . $post->thumbnail)
                                    : "https://picsum.photos/800/400?random=" . rand(1, 1000),
                    'category' => $post->category?->name ?? 'GENERAL',
                    'title'    => $post->title,
                    'author'   => $post->backendUser?->name ?? 'Unknown',
                    'date'     => $post->published_at?->format('M d, Y'),
                    'slug'     => $post->slug,
                ];
            });

        // Most Popular (berdasarkan views terbanyak)
        $mostPopulars = Post::where('status', 'published')
            ->orderByDesc('views')
            ->with(['category', 'backendUser'])
            ->take(5)
            ->get()
            ->shuffle()
            ->map(function ($post) {
                return [
                    'image'    => $post->thumbnail
                                    ? asset('storage/' . $post->thumbnail)
                                    : "https://picsum.photos/800/400?random=" . rand(1, 1000),
                    'category' => $post->category?->name ?? 'GENERAL',
                    'title'    => $post->title,
                    'author'   => $post->backendUser?->name ?? 'Unknown',
                    'date'     => $post->published_at?->format('M d, Y'),
                    'slug'     => $post->slug,
                ];
            });;

        // Latest Posts (berdasarkan tanggal publish terbaru)
        $latestNews = Post::where('status', 'published')
            ->latest('published_at')
            ->with(['category', 'backendUser'])
            ->take(10)
            ->get()
            ->shuffle()
            ->map(function ($post) {
                return [
                    'image'    => $post->thumbnail
                                    ? asset('storage/' . $post->thumbnail)
                                    : "https://picsum.photos/800/400?random=" . rand(1, 1000),
                    'category' => $post->category?->name ?? 'GENERAL',
                    'title'    => $post->title,
                    'author'   => $post->backendUser?->name ?? 'Unknown',
                    'date'     => $post->published_at?->format('M d, Y'),
                    'slug'     => $post->slug,
                ];
            });

        return Inertia::render('Home', [
            'trendingNews'     => $trendingNews,
            'mostPopulars'  => $mostPopulars,
            'latestNews'       => $latestNews,
            'slides'       => $slides,
            'rightCards'   => $rightCards,
            'companyProfile' => $companyProfile,
            'footerContacts' => $footerContacts,
            'sosmedIcons' => $sosmedIcons,
            'categories' => $categories,
        ]);
    }
}
