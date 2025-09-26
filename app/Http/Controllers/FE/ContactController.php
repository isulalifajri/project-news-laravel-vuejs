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

class ContactController extends Controller
{
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        $mostPopulars = Post::where('status', 'published')
            ->orderByDesc('views')
            ->with(['category', 'backendUser'])
            ->take(5)
            ->get()
            ->shuffle()
            ->map(fn($post) => $this->postService->transformPost($post));

        $companyProfile = CompanyProfile::take(1)->get()->map(function ($profile) {
            return [
                'name' => $profile->name ?? 'SKY NEWS',
                'about' => $profile->about ?? 'Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Minus excepturi dolorum nostrum deserunt quasi fugiat veniam! Cumque tempora, 
                doloremque possimus, ad alias ut quis eius dolorem repudiandae in distinctio ea ipsa. 
                Dicta velit assumenda culpa, a quisquam ad quibusdam cumque similique. 
                Modi voluptatibus corporis cupiditate quidem, rem excepturi magnam laudantium recusandae.
                Consectetur obcaecati molestiae ab dolorum ex asperiores nihil dignissimos inventore facere ipsam
                adipisci eveniet delectus est explicabo impedit omnis quia alias temporibus repellat, suscipit
                eaque, esse cum? Autem dignissimos reprehenderit quia repellat quam distinctio dolore rerum ab
                laboriosam placeat tempore ipsam voluptate quasi inventore, hic et ut dolorem commodi',
                'logo' => $profile->logo
                    ? asset('storage/' . $profile->logo)
                    : 'https://picsum.photos/800/400?random=logo',
            ];
        })->first();

        $footerContacts = FooterContact::where('is_active', true)
            ->whereNull('icon')
            ->get();

        $sosmedIcons = FooterContact::where('is_active', true)
            ->whereNotNull('icon')
            ->get();

        $categories = Category::all();

        return Inertia::render('Contact', [
            'categories'     => $categories,
            'companyProfile' => $companyProfile,
            'footerContacts' => $footerContacts,
            'sosmedIcons'    => $sosmedIcons,
            'mostPopulars'   => $mostPopulars,
        ]);
    }
}
