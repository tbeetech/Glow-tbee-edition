<?php

namespace App\Livewire\Page;

use App\Models\Staff\StaffMember;
use Livewire\Component;
use Illuminate\Support\Str;

class StaffDetail extends Component
{
    public StaffMember $staff;

    public function mount($slug)
    {
        $this->staff = StaffMember::where('slug', $slug)
            ->where('is_active', true)
            ->with(['departmentRelation', 'teamRole'])
            ->firstOrFail();
    }

    public function render()
    {
        $description = Str::limit(strip_tags($this->staff->bio ?? ''), 160);

        return view('livewire.page.staff-detail', [
            'staff' => $this->staff,
        ])->layout('layouts.app', [
            'title' => $this->staff->name . ' - Glow FM',
            'meta_description' => $description ?: 'Meet our team at Glow FM.',
            'meta_image' => $this->staff->photo_url,
            'meta_type' => 'profile',
        ]);
    }
}
