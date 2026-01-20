<?php

namespace App\Livewire\Admin\Stream;

use App\Models\Setting;
use Livewire\Component;

class LiveStream extends Component
{
    public $stream_url = '';
    public $is_live = true;
    public $status_message = '';
    public $now_playing_title = '';
    public $now_playing_artist = '';
    public $show_name = '';
    public $show_time = '';

    public function mount()
    {
        $station = Setting::get('station', []);
        $stream = Setting::get('stream', []);

        $this->stream_url = $stream['stream_url'] ?? ($station['stream_url'] ?? '');
        $this->is_live = $stream['is_live'] ?? true;
        $this->status_message = $stream['status_message'] ?? 'Broadcasting live now';
        $this->now_playing_title = $stream['now_playing_title'] ?? 'Blinding Lights';
        $this->now_playing_artist = $stream['now_playing_artist'] ?? 'The Weeknd';
        $this->show_name = $stream['show_name'] ?? 'Morning Vibes';
        $this->show_time = $stream['show_time'] ?? '6:00 AM - 10:00 AM';
    }

    public function save()
    {
        Setting::set('stream', [
            'stream_url' => $this->stream_url,
            'is_live' => $this->is_live,
            'status_message' => $this->status_message,
            'now_playing_title' => $this->now_playing_title,
            'now_playing_artist' => $this->now_playing_artist,
            'show_name' => $this->show_name,
            'show_time' => $this->show_time,
        ], 'stream');

        $station = Setting::get('station', []);
        $station['stream_url'] = $this->stream_url;
        Setting::set('station', $station, 'station');

        session()->flash('success', 'Live stream settings updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.stream.live-stream')
            ->layout('layouts.admin', ['header' => 'Live Stream']);
    }
}
