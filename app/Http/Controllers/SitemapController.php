<?php

namespace App\Http\Controllers;

use App\Models\Blog\Post as BlogPost;
use App\Models\Event\Event;
use App\Models\News\News;
use App\Models\Podcast\Episode as PodcastEpisode;
use App\Models\Podcast\Show as PodcastShow;
use App\Models\Show\OAP;
use App\Models\Show\Show as RadioShow;
use App\Models\Staff\StaffMember;

class SitemapController extends Controller
{
    public function index()
    {
        $staticUrls = [
            ['loc' => url('/'), 'changefreq' => 'daily', 'priority' => '1.0'],
            ['loc' => url('/about'), 'changefreq' => 'yearly', 'priority' => '0.6'],
            ['loc' => url('/contact'), 'changefreq' => 'yearly', 'priority' => '0.6'],
            ['loc' => url('/privacy-policy'), 'changefreq' => 'yearly', 'priority' => '0.3'],
            ['loc' => url('/shows'), 'changefreq' => 'weekly', 'priority' => '0.7'],
            ['loc' => url('/schedule'), 'changefreq' => 'weekly', 'priority' => '0.7'],
            ['loc' => url('/oaps'), 'changefreq' => 'weekly', 'priority' => '0.6'],
            ['loc' => url('/team'), 'changefreq' => 'weekly', 'priority' => '0.6'],
            ['loc' => url('/blog'), 'changefreq' => 'daily', 'priority' => '0.8'],
            ['loc' => url('/news'), 'changefreq' => 'daily', 'priority' => '0.8'],
            ['loc' => url('/events'), 'changefreq' => 'weekly', 'priority' => '0.7'],
            ['loc' => url('/podcasts'), 'changefreq' => 'weekly', 'priority' => '0.7'],
        ];

        $radioShowUrls = RadioShow::active()
            ->get(['slug', 'updated_at'])
            ->map(function ($show) {
                return [
                    'loc' => route('shows.show', $show->slug),
                    'lastmod' => $show->updated_at?->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.6',
                ];
            });

        $oapUrls = OAP::active()
            ->get(['slug', 'updated_at'])
            ->map(function ($oap) {
                return [
                    'loc' => route('oaps.show', $oap->slug),
                    'lastmod' => $oap->updated_at?->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.5',
                ];
            });

        $staffUrls = StaffMember::where('is_active', true)
            ->get(['slug', 'updated_at'])
            ->map(function ($staff) {
                return [
                    'loc' => route('staff.show', $staff->slug),
                    'lastmod' => $staff->updated_at?->toAtomString(),
                    'changefreq' => 'monthly',
                    'priority' => '0.4',
                ];
            });

        $newsUrls = News::published()
            ->get(['slug', 'published_at', 'updated_at'])
            ->map(function ($news) {
                return [
                    'loc' => route('news.show', $news->slug),
                    'lastmod' => ($news->published_at ?? $news->updated_at)?->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.6',
                ];
            });

        $eventUrls = Event::published()
            ->get(['slug', 'published_at', 'updated_at'])
            ->map(function ($event) {
                return [
                    'loc' => route('events.show', $event->slug),
                    'lastmod' => ($event->published_at ?? $event->updated_at)?->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.6',
                ];
            });

        $blogUrls = BlogPost::published()
            ->get(['slug', 'published_at', 'updated_at'])
            ->map(function ($post) {
                return [
                    'loc' => route('blog.show', $post->slug),
                    'lastmod' => ($post->published_at ?? $post->updated_at)?->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.6',
                ];
            });

        $podcastShowUrls = PodcastShow::active()
            ->get(['slug', 'updated_at'])
            ->map(function ($show) {
                return [
                    'loc' => route('podcasts.show', $show->slug),
                    'lastmod' => $show->updated_at?->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.6',
                ];
            });

        $podcastEpisodeUrls = PodcastEpisode::published()
            ->whereHas('show', function ($query) {
                $query->where('is_active', true);
            })
            ->with(['show:id,slug'])
            ->get(['id', 'show_id', 'slug', 'published_at', 'updated_at'])
            ->map(function ($episode) {
                if (!$episode->show) {
                    return null;
                }

                return [
                    'loc' => route('podcasts.episode', [
                        'showSlug' => $episode->show->slug,
                        'episodeSlug' => $episode->slug,
                    ]),
                    'lastmod' => ($episode->published_at ?? $episode->updated_at)?->toAtomString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.5',
                ];
            })
            ->filter();

        $urls = collect($staticUrls)
            ->concat($radioShowUrls)
            ->concat($oapUrls)
            ->concat($staffUrls)
            ->concat($newsUrls)
            ->concat($eventUrls)
            ->concat($blogUrls)
            ->concat($podcastShowUrls)
            ->concat($podcastEpisodeUrls)
            ->values();

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml');
    }
}
