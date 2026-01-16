<?php

namespace App\Livewire\Page;

use App\Models\Show\ScheduleSlot;
use Livewire\Component;

class SchedulePage extends Component
{
    public $scheduleByDay = [];

    public function mount()
    {
        $days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
        $slots = ScheduleSlot::with(['show', 'oap'])
            ->active()
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get()
            ->groupBy('day_of_week');

        $this->scheduleByDay = collect($days)->mapWithKeys(function ($day) use ($slots) {
            return [$day => $slots->get($day, collect())];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.page.schedule-page', [
            'scheduleByDay' => $this->scheduleByDay,
        ])->layout('layouts.app', ['title' => 'Weekly Schedule - Glow FM']);
    }
}
