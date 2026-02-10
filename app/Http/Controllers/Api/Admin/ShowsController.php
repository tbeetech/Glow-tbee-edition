<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Show\Show;
use Illuminate\Http\Request;

class ShowsController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $status = $request->query('status', 'all');
        $perPage = (int) $request->query('per_page', 15);
        $perPage = min(50, max(10, $perPage));

        $query = Show::with(['category', 'primaryHost']);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('full_description', 'like', "%{$search}%");
            });
        }

        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        $shows = $query->orderBy('title')->paginate($perPage);

        $data = $shows->getCollection()->map(function (Show $item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'slug' => $item->slug,
                'is_active' => (bool) $item->is_active,
                'is_featured' => (bool) $item->is_featured,
                'format' => $item->format,
                'typical_duration' => $item->typical_duration,
                'total_listeners' => $item->total_listeners,
                'category' => $item->category ? [
                    'name' => $item->category->name,
                    'slug' => $item->category->slug,
                ] : null,
                'primary_host' => $item->primaryHost ? [
                    'name' => $item->primaryHost->name,
                    'slug' => $item->primaryHost->slug,
                ] : null,
            ];
        })->values();

        return response()->json([
            'data' => $data,
            'meta' => [
                'pagination' => [
                    'current_page' => $shows->currentPage(),
                    'last_page' => $shows->lastPage(),
                    'per_page' => $shows->perPage(),
                    'total' => $shows->total(),
                ],
            ],
        ]);
    }
}
