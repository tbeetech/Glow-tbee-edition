<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            session()->flash('error', 'You cannot deactivate your own account.');
            return;
        }

        $user->is_active = !$user->is_active;
        $user->save();

        session()->flash('success', 'User status updated.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            session()->flash('error', 'You cannot delete your own account.');
            return;
        }

        $user->delete();

        session()->flash('success', 'User deleted successfully.');
        $this->resetPage();
    }

    public function getUsersProperty()
    {
        return User::query()
            ->with(['department', 'teamRole'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%")
                    ->orWhere('role', 'like', "%{$this->search}%")
                    ->orWhereHas('department', function ($dept) {
                        $dept->where('name', 'like', "%{$this->search}%");
                    })
                    ->orWhereHas('teamRole', function ($role) {
                        $role->where('name', 'like', "%{$this->search}%");
                    });
            })
            ->latest()
            ->paginate(12);
    }

    public function render()
    {
        return view('livewire.admin.users.index', [
            'users' => $this->users,
        ])->layout('layouts.admin', ['header' => 'User Management']);
    }
}
