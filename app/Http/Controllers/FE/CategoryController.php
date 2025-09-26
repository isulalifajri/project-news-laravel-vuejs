<?php

namespace App\Http\Controllers\FE;

use App\Models\Post;
use App\Models\Category;
use App\Models\FooterContact;
use App\Models\CompanyProfile;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Services\PostService;

class CategoryController extends Controller
{
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Tampilkan halaman category dengan post
     */
    public function show(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

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

        // Latest News
        $latestNews = Post::where('status', 'published')
            ->latest('published_at')
            ->with(['category', 'backendUser'])
            ->take(10)
            ->get()
            ->shuffle()
            ->map(fn($post) => $this->postService->transformPost($post));

        // Trending News (samakan style)
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

        // Category Posts (pagination)
        $categoryPosts = Post::where('status', 'published')
            ->whereHas('category', fn($q) => $q->where('slug', $slug))
            ->latest('published_at')
            ->with(['category', 'backendUser'])
            ->paginate(6)
            ->through(fn($post) => $this->postService->transformPost($post));

        return Inertia::render('Categories/category', [
            'category'       => $category,
            'categories'     => $categories,
            'categoryPosts'  => $categoryPosts,
            'latestNews'     => $latestNews,
            'trendingNews'   => $trendingNews,
            'mostPopulars'   => $mostPopulars,
            'companyProfile' => $companyProfile,
            'footerContacts' => $footerContacts,
            'sosmedIcons'    => $sosmedIcons,
        ]);
    }

    /**
     * JSON API untuk posts per category
     */
    public function posts(string $slug)
    {
        $posts = Post::where('status', 'published')
            ->whereHas('category', fn($q) => $q->where('slug', $slug))
            ->latest('published_at')
            ->with(['category', 'backendUser'])
            ->paginate(6)
            ->through(fn($post) => $this->postService->transformPost($post));

        return response()->json($posts);
    }
}
