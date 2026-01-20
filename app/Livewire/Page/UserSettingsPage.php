<?php

namespace App\Livewire\Page;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserSettingsPage extends Component
{
    public $current_password = '';
    public $password = '';
    public $password_confirmation = '';

    protected $rules = [
        'current_password' => 'required',
        'password' => 'required|min:8|confirmed',
    ];

    public function save()
    {
        $this->validate();

        $user = auth()->user();
        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Current password is incorrect.');
            return;
        }

        $user->update([
            'password' => $this->password,
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);
        session()->flash('success', 'Password updated successfully.');
    }

    public function render()
    {
        return view('livewire.page.user-settings-page')
            ->layout('layouts.app', ['title' => 'Account Settings - Glow FM']);
    }
}
