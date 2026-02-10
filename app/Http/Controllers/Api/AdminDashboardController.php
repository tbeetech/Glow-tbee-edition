<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog\Post;
use App\Models\ContactMessage;
use App\Models\Event\Event;
use App\Models\News\News;
use App\Models\Podcast\Episode as PodcastEpisode;
use App\Models\Podcast\Show as PodcastShow;
use App\Models\Show\Show;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function overview(Request $request)
    {
        return response()->json([
            'user' => $this->formatUser($request->user()),
            'stats' => [
                'news' => News::published()->count(),
                'blog_posts' => Post::published()->count(),
                'events' => Event::published()->count(),
                'shows' => Show::active()->count(),
                'podcast_shows' => PodcastShow::active()->count(),
                'podcast_episodes' => PodcastEpisode::published()->count(),
                'contact_unread' => ContactMessage::where(function ($query) {
                    $query->where('is_read', false)->orWhereNull('is_read');
                })->count(),
                'users' => User::where('is_active', true)->count(),
            ],
        ]);
    }

    private function formatUser(?User $user): ?array
    {
        if (!$user) {
            return null;
        }

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'role_label' => $user->role_label ?? null,
        ];
    }
}
