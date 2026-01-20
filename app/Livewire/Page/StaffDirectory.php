<?php

namespace App\Livewire\Page;

use App\Models\Staff\StaffMember;
use Livewire\Component;
use Livewire\WithPagination;

class StaffDirectory extends Component
{
    use WithPagination;

    public $searchQuery = '';

    protected $queryString = [
        'searchQuery' => ['except' => ''],
    ];

    public function updatingSearchQuery()
    {
        $this->resetPage();
    }

    public function getStaffMembersProperty()
    {
        return StaffMember::query()
            ->with(['departmentRelation', 'teamRole'])
            ->where('is_active', true)
            ->when($this->searchQuery, function ($query) {
                $query->where('name', 'like', "%{$this->searchQuery}%")
                    ->orWhere('role', 'like', "%{$this->searchQuery}%")
                    ->orWhere('department', 'like', "%{$this->searchQuery}%")
                    ->orWhereHas('departmentRelation', function ($dept) {
                        $dept->where('name', 'like', "%{$this->searchQuery}%");
                    })
                    ->orWhereHas('teamRole', function ($role) {
                        $role->where('name', 'like', "%{$this->searchQuery}%");
                    });
            })
            ->orderBy('name')
            ->paginate(12);
    }

    public function render()
    {
        return view('livewire.page.staff-directory', [
            'staffMembers' => $this->staffMembers,
        ])->layout('layouts.app', ['title' => 'Staff Directory - Glow FM']);
    }
}
