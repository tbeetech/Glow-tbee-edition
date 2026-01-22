<?php

namespace App\Livewire\Page;

use Livewire\Component;

class PrivacyPolicy extends Component
{
    public function render()
    {
        return view('livewire.page.privacy-policy')
            ->layout('layouts.app', [
                'title' => 'Privacy Policy - Glow FM',
            ]);
    }
}
