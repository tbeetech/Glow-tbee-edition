<?php

namespace App\Livewire\Page;

use App\Models\Show\Show;
use App\Models\Show\Category;
use Livewire\Component;
use Livewire\WithPagination;

class ShowPage extends Component
{
    use WithPagination;

    public $selectedCategory = 'all';
    public $searchQuery = '';
    public $sortBy = 'featured';

    protected $queryString = [
        'selectedCategory' => ['except' => 'all'],
        'searchQuery' => ['except' => ''],
        'sortBy' => ['except' => 'featured'],
    ];

    public function updatingSearchQuery()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function getShowsProperty()
    {
        $query = Show::with(['category', 'primaryHost'])
            ->active();

        if ($this->selectedCategory !== 'all') {
            $query->byCategory($this->selectedCategory);
        }

        if (!empty($this->searchQuery)) {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->searchQuery}%")
                  ->orWhere('description', 'like', "%{$this->searchQuery}%");
            });
        }

        switch ($this->sortBy) {
            case 'popular':
                $query->orderBy('total_listeners', 'desc');
                break;
            case 'latest':
                $query->latest();
                break;
            default:
                $query->orderBy('is_featured', 'desc')->orderBy('title');
        }

        return $query->paginate(9);
    }

    public function getFeaturedShowProperty()
    {
        return Show::with(['category', 'primaryHost'])
            ->active()
            ->featured()
            ->latest()
            ->first();
    }

    public function getCategoriesProperty()
    {
        return Category::active()
            ->withCount('shows')
            ->get();
    }

    public function render()
    {
        return view('livewire.page.show-page', [
            'shows' => $this->shows,
            'featuredShow' => $this->featuredShow,
            'categories' => $this->categories->map(function ($cat) {
                return [
                    'slug' => $cat->slug,
                    'name' => $cat->name,
                    'count' => $cat->shows_count,
                    'icon' => $cat->icon,
                    'color' => $cat->color,
                ];
            })->prepend([
                'slug' => 'all',
                'name' => 'All Shows',
                'count' => Show::active()->count(),
                'icon' => 'fas fa-microphone',
                'color' => 'emerald',
            ])->toArray(),
        ])->layout('layouts.app', ['title' => 'Shows & Programs - Glow FM']);
    }
}
