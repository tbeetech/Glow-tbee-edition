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
    public $segment_start_minute = 0;
    public $segment_duration = 5;
    public $segment_type = 'other';

    public $allShows = [];

    protected $rules = [
        'segment_show_id' => 'required|exists:shows,id',
        'segment_title' => 'required|min:3|max:255',
        'segment_start_minute' => 'required|integer|min:0',
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
            $this->segment_start_minute = $segment->start_minute;
            $this->segment_duration = $segment->duration;
            $this->segment_type = $segment->type;
        }
    }

    public function save()
    {
        $this->validate();

        $order = Segment::where('show_id', $this->segment_show_id)->max('order') ?? 0;

        $data = [
            'show_id' => $this->segment_show_id,
            'title' => $this->segment_title,
            'description' => $this->segment_description,
            'start_minute' => $this->segment_start_minute,
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
