<?php

namespace App\Livewire\Page;

use App\Models\Show\OAP;
use Livewire\Component;

class OapDetail extends Component
{
    public OAP $oap;

    public function mount($slug)
    {
        $this->oap = OAP::with(['shows'])
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.page.oap-detail', [
            'oap' => $this->oap,
        ])->layout('layouts.app', ['title' => $this->oap->name . ' - Glow FM']);
    }
}
