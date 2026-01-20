<?php

namespace App\Livewire\Page;

use Livewire\Component;

class ContactSuccess extends Component
{
    public function render()
    {
        return view('livewire.page.contact-success')
            ->layout('layouts.app', ['title' => 'Message Sent - Glow FM']);
    }
}
