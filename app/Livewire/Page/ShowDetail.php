<?php

namespace App\Livewire\Page;

use App\Models\Show\Show;
use App\Models\Show\Review;
use Illuminate\Support\Str;
use Livewire\Component;

class ShowDetail extends Component
{
    public Show $show;
    public $rating = 0;
    public $review = '';

    public function mount($slug)
    {
        $this->show = Show::with(['category', 'primaryHost', 'segments', 'scheduleSlots'])
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();

        $this->loadUserReview();
    }

    public function getUpcomingSlotsProperty()
    {
        return $this->show->scheduleSlots()
            ->active()
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();
    }

    private function loadUserReview(): void
    {
        if (!auth()->check()) {
            return;
        }

        $existing = Review::where('show_id', $this->show->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existing) {
            $this->rating = $existing->rating;
            $this->review = $existing->review ?? '';
        }
    }

    public function submitReview()
    {
        if (!auth()->check()) {
            $this->addError('rating', 'Please sign in to leave a review.');
            return;
        }

        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        Review::updateOrCreate(
            [
                'show_id' => $this->show->id,
                'user_id' => auth()->id(),
            ],
            [
                'rating' => $this->rating,
                'review' => $this->review ?: null,
                'is_approved' => true,
            ]
        );

        $averageRating = $this->show->reviews()->avg('rating');
        $this->show->average_rating = $averageRating ?: 0;
        $this->show->save();

        $this->show->load('reviews.user');
        session()->flash('success', 'Thanks for your review!');
    }

    public function render()
    {
        return view('livewire.page.show-detail', [
            'upcomingSlots' => $this->upcomingSlots,
            'reviews' => $this->show->reviews()->latest()->with('user')->get(),
        ])->layout('layouts.app', [
            'title' => $this->show->title . ' - Glow FM',
            'meta_title' => $this->show->title . ' - Glow FM',
            'meta_description' => Str::limit(strip_tags($this->show->description ?? ''), 180),
            'meta_image' => $this->show->cover_image,
        ]);
    }
}
