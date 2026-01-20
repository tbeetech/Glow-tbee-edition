<?php

namespace App\Livewire\Admin\Blog;

use App\Models\Blog\Comment;
use App\Models\Blog\Interaction;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Analytics extends Component
{
    public $range = '30';

    public function getRangeStartProperty()
    {
        if ($this->range === 'all') {
            return null;
        }

        $days = max(1, (int) $this->range);

        return now()->subDays($days)->startOfDay();
    }

    public function render()
    {
        $rangeStart = $this->rangeStart;
        $rangeLabel = $this->range === 'all' ? 'All time' : 'Last ' . $this->range . ' days';

        $baseInteractions = Interaction::query();
        $baseComments = Comment::query();

        if ($rangeStart) {
            $baseInteractions->where('created_at', '>=', $rangeStart);
            $baseComments->where('created_at', '>=', $rangeStart);
        }

        $totalViews = (clone $baseInteractions)->where('type', 'view')->count();
        $uniqueReaders = (clone $baseInteractions)
            ->where('type', 'view')
            ->whereNotNull('ip_address')
            ->distinct('ip_address')
            ->count('ip_address');
        $totalReactions = (clone $baseInteractions)->where('type', 'reaction')->count();
        $totalComments = (clone $baseComments)->approved()->count();

        $stats = [
            'total_views' => $totalViews,
            'unique_readers' => $uniqueReaders,
            'total_reactions' => $totalReactions,
            'total_comments' => $totalComments,
        ];

        $topPosts = DB::table('blog_interactions')
            ->join('blog_posts', 'blog_posts.id', '=', 'blog_interactions.post_id')
            ->select(
                'blog_posts.id',
                'blog_posts.title',
                'blog_posts.slug',
                'blog_posts.featured_image',
                DB::raw('count(*) as views')
            )
            ->where('blog_interactions.type', 'view')
            ->when($rangeStart, function ($query) use ($rangeStart) {
                $query->where('blog_interactions.created_at', '>=', $rangeStart);
            })
            ->groupBy('blog_posts.id', 'blog_posts.title', 'blog_posts.slug', 'blog_posts.featured_image')
            ->orderByDesc('views')
            ->limit(5)
            ->get();

        $topCategories = DB::table('blog_interactions')
            ->join('blog_posts', 'blog_posts.id', '=', 'blog_interactions.post_id')
            ->join('blog_categories', 'blog_categories.id', '=', 'blog_posts.category_id')
            ->select(
                'blog_categories.id',
                'blog_categories.name',
                'blog_categories.color',
                DB::raw('count(*) as views')
            )
            ->where('blog_interactions.type', 'view')
            ->when($rangeStart, function ($query) use ($rangeStart) {
                $query->where('blog_interactions.created_at', '>=', $rangeStart);
            })
            ->groupBy('blog_categories.id', 'blog_categories.name', 'blog_categories.color')
            ->orderByDesc('views')
            ->limit(5)
            ->get();

        $engagementMix = (clone $baseInteractions)
            ->select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->orderByDesc('total')
            ->get();

        $reactionBreakdown = (clone $baseInteractions)
            ->where('type', 'reaction')
            ->select('value', DB::raw('count(*) as total'))
            ->groupBy('value')
            ->orderByDesc('total')
            ->get();

        $recentComments = DB::table('blog_comments')
            ->join('blog_posts', 'blog_posts.id', '=', 'blog_comments.post_id')
            ->select(
                'blog_comments.id',
                'blog_comments.comment',
                'blog_comments.is_approved',
                'blog_comments.created_at',
                'blog_posts.title as post_title'
            )
            ->when($rangeStart, function ($query) use ($rangeStart) {
                $query->where('blog_comments.created_at', '>=', $rangeStart);
            })
            ->orderByDesc('blog_comments.created_at')
            ->limit(10)
            ->get();

        return view('livewire.admin.blog.analytics', [
            'stats' => $stats,
            'rangeLabel' => $rangeLabel,
            'topPosts' => $topPosts,
            'topCategories' => $topCategories,
            'engagementMix' => $engagementMix,
            'reactionBreakdown' => $reactionBreakdown,
            'recentComments' => $recentComments,
        ])->layout('layouts.admin', ['header' => 'Blog Analytics']);
    }
}
