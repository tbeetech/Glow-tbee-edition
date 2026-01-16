<?php

namespace App\Livewire\Page;

use App\Models\Show\Show;
use Livewire\Component;

class ShowDetail extends Component
{
    public Show $show;

    public function mount($slug)
    {
        $this->show = Show::with(['category', 'primaryHost', 'segments', 'scheduleSlots'])
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function getUpcomingSlotsProperty()
    {
        return $this->show->scheduleSlots()
            ->active()
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();
    }

    public function render()
    {
        return view('livewire.page.show-detail', [
            'upcomingSlots' => $this->upcomingSlots,
        ])->layout('layouts.app', [
            'title' => $this->show->title . ' - Glow FM'
        ]);
    }
}
