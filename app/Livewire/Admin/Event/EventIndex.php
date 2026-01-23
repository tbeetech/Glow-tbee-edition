<?php

namespace App\Livewire\Admin\Event;

use App\Models\Event\Event;
use App\Models\Event\EventCategory;
use App\Models\Setting;
use App\Notifications\ContentApprovalUpdated;
use Livewire\Component;
use Livewire\WithPagination;

class EventIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $filterCategory = '';
    public $filterStatus = '';
    public $showDeleteModal = false;
    public $eventToDelete = null;
    public $showApprovalModal = false;
    public $approvalTargetId = null;
    public $approvalAction = '';
    public $approvalReason = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'filterCategory' => ['except' => ''],
        'filterStatus' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterCategory()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function confirmDelete($eventId)
    {
        $this->eventToDelete = $eventId;
        $this->showDeleteModal = true;
    }

    public function deleteEvent()
    {
        if ($this->eventToDelete) {
            $event = Event::find($this->eventToDelete);

            if ($event) {
                $event->comments()->delete();
                $event->interactions()->delete();
                $event->delete();

                session()->flash('success', 'Event deleted successfully!');
            }
        }

        $this->showDeleteModal = false;
        $this->eventToDelete = null;
    }

    public function togglePublish($eventId)
    {
        $event = Event::find($eventId);

        if ($event) {
            if (!$event->is_published && $event->approval_status !== 'approved') {
                session()->flash('error', 'This event must be approved before publishing.');
                return;
            }

            $event->is_published = !$event->is_published;

            if ($event->is_published && !$event->published_at) {
                $event->published_at = now();
            }

            $event->save();

            $status = $event->is_published ? 'published' : 'unpublished';
            session()->flash('success', "Event {$status} successfully!");
        }
    }

    public function openApprovalModal($eventId, $action)
    {
        if (!$this->canReview()) {
            session()->flash('error', 'You do not have permission to review content.');
            return;
        }

        $this->approvalTargetId = $eventId;
        $this->approvalAction = $action;
        $this->approvalReason = '';
        $this->showApprovalModal = true;
    }

    public function submitApproval()
    {
        if (!$this->canReview() || !$this->approvalTargetId) {
            session()->flash('error', 'Unable to update approval status.');
            return;
        }

        $requiresReason = in_array($this->approvalAction, ['flagged', 'rejected'], true);

        $this->validate([
            'approvalReason' => $requiresReason ? 'required|min:5|max:1000' : 'nullable|max:1000',
        ]);

        $event = Event::find($this->approvalTargetId);
        if (!$event) {
            session()->flash('error', 'Event not found.');
            return;
        }

        $event->approval_status = $this->approvalAction;
        $event->approval_reason = $this->approvalReason ?: null;
        $event->reviewed_by = auth()->id();
        $event->reviewed_at = now();

        if (in_array($this->approvalAction, ['flagged', 'rejected'], true)) {
            $event->is_published = false;
            $event->published_at = null;
        } elseif ($event->is_published && !$event->published_at) {
            $event->published_at = now();
        }

        $event->save();

        if ($event->author) {
            $event->author->notify(new ContentApprovalUpdated(
                'event',
                $event->title,
                $this->approvalAction,
                $this->approvalReason ?: null
            ));
        }

        $this->showApprovalModal = false;
        $this->approvalTargetId = null;
        $this->approvalReason = '';
        $this->approvalAction = '';

        session()->flash('success', 'Approval status updated successfully.');
    }

    private function canReview(): bool
    {
        $user = auth()->user();
        if (!$user) {
            return false;
        }

        if ($user->isAdmin()) {
            return true;
        }

        $approverId = Setting::get('system.content_approver_id');
        return $approverId && $user->staffMember && $user->staffMember->id === (int) $approverId;
    }

    public function toggleFeatured($eventId)
    {
        $event = Event::find($eventId);

        if ($event) {
            if (!$event->is_featured) {
                Event::where('is_featured', true)->update(['is_featured' => false]);
            }

            $event->is_featured = !$event->is_featured;
            $event->save();

            session()->flash('success', 'Featured status updated successfully!');
        }
    }

    public function getEventsProperty()
    {
        $query = Event::with(['category', 'author'])
            ->latest('start_at');

        if (!empty($this->search)) {
            $query->search($this->search);
        }

        if (!empty($this->filterCategory)) {
            $query->where('category_id', $this->filterCategory);
        }

        if ($this->filterStatus === 'published') {
            $query->where('is_published', true);
        } elseif ($this->filterStatus === 'draft') {
            $query->where('is_published', false);
        } elseif ($this->filterStatus === 'featured') {
            $query->where('is_featured', true);
        } elseif ($this->filterStatus === 'upcoming') {
            $query->upcoming();
        } elseif ($this->filterStatus === 'past') {
            $query->past();
        } elseif ($this->filterStatus === 'pending') {
            $query->where('approval_status', 'pending');
        } elseif ($this->filterStatus === 'approved') {
            $query->where('approval_status', 'approved');
        } elseif ($this->filterStatus === 'flagged') {
            $query->where('approval_status', 'flagged');
        } elseif ($this->filterStatus === 'rejected') {
            $query->where('approval_status', 'rejected');
        }

        return $query->paginate(10);
    }

    public function getCategoriesProperty()
    {
        return EventCategory::active()->get();
    }

    public function getStatsProperty()
    {
        return [
            'total' => Event::count(),
            'published' => Event::where('is_published', true)->count(),
            'draft' => Event::where('is_published', false)->count(),
            'featured' => Event::where('is_featured', true)->count(),
            'upcoming' => Event::where('start_at', '>=', now())->count(),
        ];
    }

    public function render()
    {
        return view('livewire.admin.event.index', [
            'events' => $this->events,
            'categories' => $this->categories,
            'stats' => $this->stats,
        ])->layout('layouts.admin', [
            'header' => 'Event Management'
        ]);
    }
}
