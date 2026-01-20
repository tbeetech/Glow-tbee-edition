<?php

namespace App\Livewire\Admin\Community;

use Livewire\Component;

class Placeholder extends Component
{
    public string $title = 'Community';
    public string $subtitle = 'Community management';
    public string $icon = 'fas fa-users';
    public string $accent = 'emerald';
    public string $description = 'This area is ready for data once we connect the source.';

    public function mount(
        string $title = 'Community',
        string $subtitle = 'Community management',
        string $icon = 'fas fa-users',
        string $accent = 'emerald',
        string $description = 'This area is ready for data once we connect the source.'
    ) {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->icon = $icon;
        $this->accent = $accent;
        $this->description = $description;
    }

    public function render()
    {
        return view('livewire.admin.community.placeholder')
            ->layout('layouts.admin', ['header' => $this->title]);
    }
}
