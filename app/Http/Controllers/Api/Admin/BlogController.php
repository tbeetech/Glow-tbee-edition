<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $status = $request->query('status', 'all');
        $perPage = (int) $request->query('per_page', 15);
        $perPage = min(50, max(10, $perPage));

        $query = Post::with(['category', 'author']);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        switch ($status) {
            case 'published':
                $query->published();
                break;
            case 'draft':
                $query->where('is_published', false);
                break;
            case 'pending':
                $query->where('approval_status', 'pending');
                break;
            case 'rejected':
                $query->where('approval_status', 'rejected');
                break;
            case 'scheduled':
                $query->whereNotNull('published_at')
                    ->where('published_at', '>', now());
                break;
            default:
                // all
        }

        $posts = $query->latest('published_at')->paginate($perPage);

        $data = $posts->getCollection()->map(function (Post $item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'slug' => $item->slug,
                'is_published' => (bool) $item->is_published,
                'approval_status' => $item->approval_status,
                'published_at' => $item->published_at?->format('Y-m-d H:i:s'),
                'is_featured' => (bool) $item->is_featured,
                'category' => $item->category ? [
                    'name' => $item->category->name,
                    'slug' => $item->category->slug,
                ] : null,
                'author' => $item->author ? [
                    'name' => $item->author->name,
                    'role' => $item->author->role_label ?? 'Author',
                ] : null,
                'views' => $item->views,
                'shares' => $item->shares,
            ];
        })->values();

        return response()->json([
            'data' => $data,
            'meta' => [
                'pagination' => [
                    'current_page' => $posts->currentPage(),
                    'last_page' => $posts->lastPage(),
                    'per_page' => $posts->perPage(),
                    'total' => $posts->total(),
                ],
            ],
        ]);
    }
}
