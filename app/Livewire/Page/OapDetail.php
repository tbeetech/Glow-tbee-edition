<?php

namespace App\Livewire\Page;

use App\Models\Show\OAP;
use Illuminate\Support\Str;
use Livewire\Component;

class OapDetail extends Component
{
    public OAP $oap;

    public function mount($slug)
    {
        $this->oap = OAP::with(['shows', 'department', 'teamRole'])
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function render()
    {
        $description = Str::limit(strip_tags($this->oap->bio ?? ''), 160);

        return view('livewire.page.oap-detail', [
            'oap' => $this->oap,
        ])->layout('layouts.app', [
            'title' => $this->oap->name . ' - Glow FM',
            'meta_description' => $description ?: 'Meet our on-air personalities at Glow FM.',
            'meta_image' => $this->oap->profile_photo,
            'meta_type' => 'profile',
        ]);
    }
}
