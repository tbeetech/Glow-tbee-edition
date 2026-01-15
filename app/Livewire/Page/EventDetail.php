<?php

namespace App\Livewire\Page;

use App\Models\Event\Event;
use Livewire\Component;

class EventDetail extends Component
{
    public Event $event;
    public $comment = '';
    public $userReactions = [];
    public $isBookmarked = false;

    public function mount($slug)
    {
        $query = Event::with(['category', 'author', 'comments.user']);

        if (!request()->routeIs('admin.events.preview')) {
            $query->published();
        }

        $this->event = $query->where('slug', $slug)->firstOrFail();

        $this->event->incrementViews(request()->ip(), auth()->id());

        if (auth()->check()) {
            $this->loadUserInteractions();
        }
    }

    private function loadUserInteractions()
    {
        $userId = auth()->id();

        $reactions = $this->event->interactions()
            ->where('user_id', $userId)
            ->where('type', 'reaction')
            ->pluck('value')
            ->toArray();

        $this->userReactions = array_fill_keys($reactions, true);
        $this->isBookmarked = $this->event->isBookmarkedBy($userId);
    }

    public function toggleReaction($type)
    {
        if (!auth()->check()) {
            session()->flash('error', 'Please login to react');
            return redirect()->route('login');
        }

        $toggled = $this->event->toggleReaction(auth()->id(), $type);

        if ($toggled) {
            $this->userReactions[$type] = true;
        } else {
            unset($this->userReactions[$type]);
        }

        $this->event->refresh();
    }

    public function toggleBookmark()
    {
        if (!auth()->check()) {
            session()->flash('error', 'Please login to bookmark');
            return redirect()->route('login');
        }

        $toggled = $this->event->toggleBookmark(auth()->id());
        $this->isBookmarked = $toggled;

        session()->flash('success', $toggled ?
            'Added to saved events' :
            'Removed from saved events'
        );
    }

    public function submitComment()
    {
        if (!auth()->check()) {
            session()->flash('error', 'Please login to comment');
            return redirect()->route('login');
        }

        $this->validate(['comment' => 'required|min:3|max:500']);

        $this->event->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $this->comment,
            'is_approved' => true,
        ]);

        $this->comment = '';
        $this->event->refresh();

        session()->flash('success', 'Comment posted successfully!');
    }

    public function shareEvent($platform)
    {
        $this->event->trackShare($platform);

        $url = urlencode(route('events.show', $this->event->slug));
        $title = urlencode($this->event->title);

        $shareUrls = [
            'twitter' => "https://twitter.com/intent/tweet?url={$url}&text={$title}",
            'facebook' => "https://www.facebook.com/sharer/sharer.php?u={$url}",
            'linkedin' => "https://www.linkedin.com/sharing/share-offsite/?url={$url}",
            'whatsapp' => "https://wa.me/?text={$title} {$url}",
            'telegram' => "https://t.me/share/url?url={$url}&text={$title}",
        ];

        return redirect()->away($shareUrls[$platform] ?? route('events.show', $this->event->slug));
    }

    public function getRelatedEventsProperty()
    {
        return Event::published()
            ->where('category_id', $this->event->category_id)
            ->where('id', '!=', $this->event->id)
            ->orderBy('start_at')
            ->take(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.page.event-detail', [
            'relatedEvents' => $this->relatedEvents,
            'reactions' => $this->event->getAllReactionCounts(),
        ])->layout('layouts.app', [
            'title' => $this->event->title . ' - Glow FM Events'
        ]);
    }
}
