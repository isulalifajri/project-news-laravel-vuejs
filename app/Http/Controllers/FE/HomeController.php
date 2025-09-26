<?php

namespace App\Http\Controllers\FE;

use App\Models\Post;
use App\Models\Category;
use App\Models\FooterContact;
use App\Models\CompanyProfile;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Services\PostService;

class HomeController extends Controller
{
    protected $postService;

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
        $slides = $this->postService->transformCollection(
            Post::where('status', 'published')
                ->inRandomOrder()
                ->take(5)
                ->with(['category', 'backendUser'])
                ->get()
        );

        // Right Cards (2 post populer/random)
        $rightCards = $this->postService->transformCollection(
            Post::where('status', 'published')
                ->orderByDesc('views')
                ->take(5)
                ->with(['category', 'backendUser'])
                ->get()
                ->shuffle()
        );

        // Trending News
        $trendingNews = $this->postService->transformCollection(
            Post::where('status', 'published')
                ->where(fn($q) => $q->where('is_featured', true)
                                    ->orWhere('published_at', '>=', now()->subDays(7)))
                ->orderByDesc('views')
                ->latest('published_at')
                ->with(['category', 'backendUser'])
                ->take(5)
                ->get()
        );

        // Most Popular
        $mostPopulars = $this->postService->transformCollection(
            Post::where('status', 'published')
                ->orderByDesc('views')
                ->with(['category', 'backendUser'])
                ->take(5)
                ->get()
                ->shuffle()
        );

        // Latest News
        $latestNews = $this->postService->transformCollection(
            Post::where('status', 'published')
                ->latest('published_at')
                ->with(['category', 'backendUser'])
                ->take(10)
                ->get()
                ->shuffle()
        );

        return Inertia::render('Home', [
            'slides'         => $slides,
            'rightCards'     => $rightCards,
            'trendingNews'   => $trendingNews,
            'mostPopulars'   => $mostPopulars,
            'latestNews'     => $latestNews,
            'companyProfile' => $companyProfile,
            'footerContacts' => $footerContacts,
            'sosmedIcons'    => $sosmedIcons,
            'categories'     => $categories,
        ]);
    }
}
