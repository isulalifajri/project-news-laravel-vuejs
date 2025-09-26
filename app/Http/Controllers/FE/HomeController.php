<?php

namespace App\Http\Controllers\FE;

use App\Models\Post;
use Inertia\Inertia;
use App\Models\FooterContact;
use App\Models\CompanyProfile;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Services\PostService;

class HomeController extends Controller
{
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        // Company Profile
        $companyProfile = CompanyProfile::first() ?? new CompanyProfile([
            'name' => 'SKY NEWS',
            'about' => '',
            'logo' => 'https://picsum.photos/800/400?random=logo',
        ]);

        // Footer & Sosmed
        $footerContacts = FooterContact::where('is_active', true)->whereNull('icon')->get();
        $sosmedIcons = FooterContact::where('is_active', true)->whereNotNull('icon')->get();
        $categories = Category::all();

        // Slides
        $slides = Post::where('status', 'published')
            ->inRandomOrder()
            ->take(5)
            ->with(['category', 'backendUser'])
            ->get()
            ->map(fn($post) => $this->postService->transformPost($post));

        // Right Cards
        $rightCards = Post::where('status', 'published')
            ->orderByDesc('views')
            ->take(5)
            ->with(['category', 'backendUser'])
            ->get()
            ->shuffle()
            ->map(fn($post) => $this->postService->transformPost($post));

        // Trending News
        $trendingNews = Post::where('status', 'published')
            ->where(fn($q) => $q->where('is_featured', true)
                                ->orWhere('published_at', '>=', now()->subDays(7)))
            ->orderByDesc('views')
            ->latest('published_at')
            ->with(['category', 'backendUser'])
            ->take(5)
            ->get()
            ->map(fn($post) => $this->postService->transformPost($post));

        // Most Popular
        $mostPopulars = Post::where('status', 'published')
            ->orderByDesc('views')
            ->with(['category', 'backendUser'])
            ->take(5)
            ->get()
            ->shuffle()
            ->map(fn($post) => $this->postService->transformPost($post));

        // Latest News
        $latestNews = Post::where('status', 'published')
            ->latest('published_at')
            ->with(['category', 'backendUser'])
            ->take(10)
            ->get()
            ->shuffle()
            ->map(fn($post) => $this->postService->transformPost($post));

        return Inertia::render('Home', [
            'slides'          => $slides,
            'rightCards'      => $rightCards,
            'trendingNews'    => $trendingNews,
            'mostPopulars'    => $mostPopulars,
            'latestNews'      => $latestNews,
            'companyProfile'  => $companyProfile,
            'footerContacts'  => $footerContacts,
            'sosmedIcons'     => $sosmedIcons,
            'categories'      => $categories,
        ]);
    }
}
