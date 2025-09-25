<?php

namespace App\Http\Controllers\FE;

use App\Models\Post;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\FooterContact;
use App\Models\CompanyProfile;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

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

        $categoryPosts = Post::where('status', 'published')
        ->whereHas('category', function ($q) use ($slug) {
            $q->where('slug', $slug);
        })
        ->latest('published_at')
        ->with(['category', 'backendUser'])
        ->paginate(6)
        ->through(function ($post) {
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

        $sosmedIcons = FooterContact::where('is_active', true)
        ->whereNotNull('icon')->get();

        return Inertia::render('Categories/category', [
            'category' => $category,
            'categories' => $categories,
            'categoryPosts'  => $categoryPosts,
            'latestNews'       => $latestNews,
            'trendingNews'       => $trendingNews,
            'companyProfile' => $companyProfile,
            'footerContacts' => $footerContacts,
            'sosmedIcons' => $sosmedIcons,
        ]);
    }
}
