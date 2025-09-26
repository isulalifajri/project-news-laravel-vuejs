<?php

namespace App\Http\Controllers\FE;

use App\Models\Post;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\FooterContact;
use App\Services\PostService;
use App\Models\CompanyProfile;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        $latestNews = Post::where('status', 'published')
            ->latest('published_at')
            ->with(['category', 'backendUser'])
            ->take(10)
            ->get()
            ->shuffle()
            ->map(fn($post) => $this->postService->transformPost($post));

        $trendingNews = Post::where('status', 'published')
            ->where(function ($query) {
                $query->where('is_featured', true)
                      ->orWhere('published_at', '>=', now()->subDays(7));
            })
            ->latest('published_at')
            ->orderByDesc('is_featured')
            ->orderByDesc('views')
            ->with(['category', 'backendUser'])
            ->take(5)
            ->get()
            ->map(fn($post) => $this->postService->transformPost($post));

        $mostPopulars = Post::where('status', 'published')
            ->orderByDesc('views')
            ->with(['category', 'backendUser'])
            ->take(5)
            ->get()
            ->shuffle()
            ->map(fn($post) => $this->postService->transformPost($post));

        $companyProfile = CompanyProfile::first() ?? new CompanyProfile([
            'name' => 'SKY NEWS',
            'about' => '',
            'logo' => 'https://picsum.photos/800/400?random=logo',
        ]);

        $footerContacts = FooterContact::where('is_active', true)
            ->whereNull('icon')
            ->get();

        $sosmedIcons = FooterContact::where('is_active', true)
            ->whereNotNull('icon')
            ->get();

        $categories = Category::all();

        $postNews = Post::where('status', 'published')
            ->latest('published_at')
            ->with(['category', 'backendUser'])
            ->paginate(6)
            ->through(fn($post) => $this->postService->transformPost($post));

        return Inertia::render('Posts/index', [
            'categories'     => $categories,
            'postNews'       => $postNews,
            'latestNews'     => $latestNews,
            'trendingNews'   => $trendingNews,
            'companyProfile' => $companyProfile,
            'footerContacts' => $footerContacts,
            'sosmedIcons'    => $sosmedIcons,
            'mostPopulars'   => $mostPopulars,
        ]);
    }

    /**
     * Ambil post list JSON (untuk API / pagination SPA)
     */
    public function posts()
    {
        $posts = Post::where('status', 'published')
            ->latest('published_at')
            ->with(['category', 'backendUser'])
            ->paginate(6)
            ->through(fn($post) => $this->postService->transformPost($post));

        return response()->json($posts);
    }

    /**
     * Show single post
     */
    public function showNews($slug)
    {
        $post = Post::where('slug', $slug)
            ->with(['category', 'backendUser', 'tags'])
            ->firstOrFail();

        $mostPopulars = Post::where('status', 'published')
            ->orderByDesc('views')
            ->with(['category', 'backendUser'])
            ->take(5)
            ->get()
            ->shuffle()
            ->map(fn($post) => $this->postService->transformPost($post));

        $trendingNews = Post::where('status', 'published')
            ->where(function ($query) {
                $query->where('is_featured', true)
                      ->orWhere('published_at', '>=', now()->subDays(7));
            })
            ->latest('published_at')
            ->orderByDesc('is_featured')
            ->orderByDesc('views')
            ->with(['category', 'backendUser'])
            ->take(5)
            ->get()
            ->map(fn($post) => $this->postService->transformPost($post));

        $companyProfile = CompanyProfile::first() ?? new CompanyProfile([
            'name' => 'SKY NEWS',
            'about' => '',
            'logo' => 'https://picsum.photos/800/400?random=logo',
        ]);

        $footerContacts = FooterContact::where('is_active', true)
            ->whereNull('icon')
            ->get();

        $sosmedIcons = FooterContact::where('is_active', true)
            ->whereNotNull('icon')
            ->get();

        $categories = Category::all();

        return Inertia::render('Posts/show', [
            'post' => $this->postService->transformPost($post),
            'categories'     => $categories,
            'trendingNews'   => $trendingNews,
            'companyProfile' => $companyProfile,
            'footerContacts' => $footerContacts,
            'sosmedIcons'    => $sosmedIcons,
            'mostPopulars'   => $mostPopulars,
        ]);
    }
}
