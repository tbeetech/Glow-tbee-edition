<?php

namespace App\Livewire\Admin\Show;

use App\Models\Show\Segment;
use App\Models\Show\Show;
use Livewire\Component;

class SegmentForm extends Component
{
    public $segmentId = null;
    public $isEditing = false;

    public $segment_show_id = '';
    public $segment_title = '';
    public $segment_description = '';
    public $segment_start_time = '';
    public $segment_duration = 5;
    public $segment_type = 'other';

    public $allShows = [];

    protected $rules = [
        'segment_show_id' => 'required|exists:shows,id',
        'segment_title' => 'required|min:3|max:255',
        'segment_start_time' => 'required|date_format:H:i',
        'segment_duration' => 'required|integer|min:1',
        'segment_type' => 'required',
        'segment_description' => 'nullable|string',
    ];

    public function mount($segmentId = null)
    {
        $this->allShows = Show::orderBy('title')->get();

        if ($segmentId) {
            $segment = Segment::findOrFail($segmentId);
            $this->segmentId = $segment->id;
            $this->isEditing = true;
            $this->segment_show_id = $segment->show_id;
            $this->segment_title = $segment->title;
            $this->segment_description = $segment->description;
            $this->segment_start_time = $this->minutesToTime($segment->start_minute);
            $this->segment_duration = $segment->duration;
            $this->segment_type = $segment->type;
        }
    }

    private function timeToMinutes(string $time): int
    {
        [$hours, $minutes] = array_map('intval', explode(':', $time));
        return ($hours * 60) + $minutes;
    }

    private function minutesToTime(int $minutes): string
    {
        $hours = intdiv($minutes, 60);
        $mins = $minutes % 60;
        return sprintf('%02d:%02d', $hours, $mins);
    }

    public function save()
    {
        $this->validate();

        $order = Segment::where('show_id', $this->segment_show_id)->max('order') ?? 0;
        $startMinute = $this->timeToMinutes($this->segment_start_time);

        $data = [
            'show_id' => $this->segment_show_id,
            'title' => $this->segment_title,
            'description' => $this->segment_description,
            'start_minute' => $startMinute,
            'duration' => $this->segment_duration,
            'type' => $this->segment_type,
            'order' => $this->isEditing ? Segment::findOrFail($this->segmentId)->order : $order + 1,
        ];

        if ($this->isEditing) {
            Segment::findOrFail($this->segmentId)->update($data);
            $message = 'Segment updated successfully.';
        } else {
            Segment::create($data);
            $message = 'Segment created successfully.';
        }

        return redirect()
            ->route('admin.shows.segments')
            ->with('success', $message);
    }

    public function render()
    {
        return view('livewire.admin.show.segment-form')
            ->layout('layouts.admin', [
                'header' => $this->isEditing ? 'Edit Segment' : 'Add Segment',
            ]);
    }
}
