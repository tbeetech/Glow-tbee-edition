<?php

namespace App\Livewire\Admin\Show;

use App\Models\Show\OAP;
use App\Models\Show\ScheduleSlot;
use App\Models\Show\Show;
use Livewire\Component;

class ScheduleForm extends Component
{
    public $slotId = null;
    public $isEditing = false;

    public $schedule_show_id = '';
    public $schedule_oap_id = '';
    public $schedule_day_of_week = 'monday';
    public $schedule_start_time = '';
    public $schedule_end_time = '';
    public $schedule_start_date = '';
    public $schedule_end_date = '';
    public $schedule_is_recurring = true;
    public $schedule_status = 'active';
    public $schedule_notes = '';

    public $allShows = [];
    public $allOaps = [];

    protected $rules = [
        'schedule_show_id' => 'required|exists:shows,id',
        'schedule_day_of_week' => 'required',
        'schedule_start_time' => 'required|date_format:H:i',
        'schedule_end_time' => 'required|date_format:H:i|after:schedule_start_time',
        'schedule_start_date' => 'nullable|date',
        'schedule_end_date' => 'nullable|date|after_or_equal:schedule_start_date',
        'schedule_is_recurring' => 'boolean',
        'schedule_status' => 'required',
        'schedule_notes' => 'nullable|string',
    ];

    public function mount($slotId = null)
    {
        $this->allShows = Show::orderBy('title')->get();
        $this->allOaps = OAP::active()->get();

        if ($slotId) {
            $slot = ScheduleSlot::findOrFail($slotId);
            $this->slotId = $slot->id;
            $this->isEditing = true;
            $this->schedule_show_id = $slot->show_id;
            $this->schedule_oap_id = $slot->oap_id;
            $this->schedule_day_of_week = $slot->day_of_week;
            $this->schedule_start_time = $slot->start_time;
            $this->schedule_end_time = $slot->end_time;
            $this->schedule_start_date = $slot->start_date?->format('Y-m-d') ?? '';
            $this->schedule_end_date = $slot->end_date?->format('Y-m-d') ?? '';
            $this->schedule_is_recurring = $slot->is_recurring;
            $this->schedule_status = $slot->status;
            $this->schedule_notes = $slot->notes;
        }
    }

    public function save()
    {
        $this->validate();

        $conflictQuery = ScheduleSlot::where('day_of_week', $this->schedule_day_of_week);
        if ($this->isEditing) {
            $conflictQuery->where('id', '!=', $this->slotId);
        }

        $timeConflict = $conflictQuery->get()->first(function ($slot) {
            return $slot->hasConflictWith(
                $this->schedule_start_time,
                $this->schedule_end_time,
                $this->schedule_day_of_week
            );
        });

        if ($timeConflict) {
            $this->addError('schedule_start_time', 'This slot conflicts with another scheduled show.');
            return;
        }

        if ($this->schedule_oap_id) {
            $oapConflict = ScheduleSlot::where('oap_id', $this->schedule_oap_id)
                ->where('day_of_week', $this->schedule_day_of_week)
                ->when($this->isEditing, function ($query) {
                    $query->where('id', '!=', $this->slotId);
                })
                ->get()
                ->first(function ($slot) {
                    return $slot->hasConflictWith(
                        $this->schedule_start_time,
                        $this->schedule_end_time,
                        $this->schedule_day_of_week
                    );
                });

            if ($oapConflict) {
                $this->addError('schedule_oap_id', 'Selected OAP is already booked for this time.');
                return;
            }
        }

        $data = [
            'show_id' => $this->schedule_show_id,
            'oap_id' => $this->schedule_oap_id ?: null,
            'day_of_week' => $this->schedule_day_of_week,
            'start_time' => $this->schedule_start_time,
            'end_time' => $this->schedule_end_time,
            'start_date' => $this->schedule_start_date ?: null,
            'end_date' => $this->schedule_end_date ?: null,
            'is_recurring' => $this->schedule_is_recurring,
            'status' => $this->schedule_status,
            'notes' => $this->schedule_notes ?: null,
        ];

        if ($this->isEditing) {
            ScheduleSlot::findOrFail($this->slotId)->update($data);
            $message = 'Schedule updated successfully.';
        } else {
            ScheduleSlot::create($data);
            $message = 'Schedule created successfully.';
        }

        return redirect()
            ->route('admin.shows.schedule')
            ->with('success', $message);
    }

    public function render()
    {
        return view('livewire.admin.show.schedule-form')
            ->layout('layouts.admin', [
                'header' => $this->isEditing ? 'Edit Schedule Slot' : 'Add Schedule Slot',
            ]);
    }
}
