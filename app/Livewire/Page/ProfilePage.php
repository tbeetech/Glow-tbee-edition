<?php

namespace App\Livewire\Page;

use Livewire\Component;

class ProfilePage extends Component
{
    public $name = '';
    public $email = '';
    public $avatar = '';

    protected $rules = [
        'name' => 'required|min:3|max:255',
        'email' => 'required|email',
        'avatar' => 'nullable|url',
    ];

    public function mount()
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->avatar = $user->avatar ?? '';
    }

    public function save()
    {
        $this->validate();

        $user = auth()->user();
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => $this->avatar ?: null,
        ]);

        session()->flash('success', 'Profile updated successfully.');
    }

    public function render()
    {
        return view('livewire.page.profile-page')
            ->layout('layouts.app', ['title' => 'My Profile - Glow FM']);
    }
}
