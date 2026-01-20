<?php

namespace App\Livewire\Page;

use App\Models\Staff\StaffMember;
use App\Models\Show\OAP;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
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

    public function getStaffProfilesProperty()
    {
        $staff = StaffMember::query()
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
            ->get()
            ->map(function ($staff) {
                return [
                    'type' => 'staff',
                    'id' => $staff->id,
                    'name' => $staff->name,
                    'slug' => $staff->slug,
                    'role' => $staff->teamRole?->name ?? ($staff->role ?? 'Staff Member'),
                    'department' => $staff->departmentRelation?->name ?? ($staff->department ?? 'General'),
                    'photo' => $staff->photo_url,
                    'bio' => $staff->bio,
                    'email' => $staff->email,
                    'phone' => $staff->phone,
                    'social_links' => $staff->social_links ?? [],
                    'profile_url' => route('staff.profile', ['type' => 'staff', 'identifier' => $staff->slug]),
                ];
            });

        $oaps = OAP::with(['department', 'teamRole'])
            ->active()
            ->when($this->searchQuery, function ($query) {
                $query->where('name', 'like', "%{$this->searchQuery}%")
                    ->orWhere('bio', 'like', "%{$this->searchQuery}%")
                    ->orWhereHas('department', function ($dept) {
                        $dept->where('name', 'like', "%{$this->searchQuery}%");
                    })
                    ->orWhereHas('teamRole', function ($role) {
                        $role->where('name', 'like', "%{$this->searchQuery}%");
                    });
            })
            ->get()
            ->map(function ($oap) {
                return [
                    'type' => 'oap',
                    'id' => $oap->id,
                    'name' => $oap->name,
                    'slug' => $oap->slug,
                    'role' => $oap->teamRole?->name ?? 'On-Air Personality',
                    'department' => $oap->department?->name ?? 'Broadcast',
                    'photo' => $oap->profile_photo,
                    'bio' => $oap->bio,
                    'email' => $oap->email,
                    'phone' => $oap->phone,
                    'social_links' => $oap->social_media ?? [],
                    'profile_url' => route('staff.profile', ['type' => 'oap', 'identifier' => $oap->slug]),
                ];
            });

        $users = User::with(['department', 'teamRole'])
            ->where('is_active', true)
            ->where('role', '!=', 'user')
            ->when($this->searchQuery, function ($query) {
                $query->where('name', 'like', "%{$this->searchQuery}%")
                    ->orWhere('role', 'like', "%{$this->searchQuery}%")
                    ->orWhereHas('department', function ($dept) {
                        $dept->where('name', 'like', "%{$this->searchQuery}%");
                    })
                    ->orWhereHas('teamRole', function ($role) {
                        $role->where('name', 'like', "%{$this->searchQuery}%");
                    });
            })
            ->get()
            ->map(function ($user) {
                return [
                    'type' => 'user',
                    'id' => $user->id,
                    'name' => $user->name,
                    'slug' => null,
                    'role' => $user->teamRole?->name ?? ucfirst($user->role),
                    'department' => $user->department?->name ?? 'General',
                    'photo' => $user->avatar,
                    'bio' => null,
                    'email' => $user->email,
                    'phone' => null,
                    'social_links' => [],
                    'profile_url' => route('staff.profile', ['type' => 'user', 'identifier' => $user->id]),
                ];
            });

        $combined = (new Collection())
            ->merge($staff)
            ->merge($oaps)
            ->merge($users)
            ->sortBy('name')
            ->values();

        $page = Paginator::resolveCurrentPage('page');
        $perPage = 12;
        $items = $combined->forPage($page, $perPage)->values();

        return new LengthAwarePaginator(
            $items,
            $combined->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }

    public function render()
    {
        return view('livewire.page.staff-directory', [
            'staffProfiles' => $this->staffProfiles,
        ])->layout('layouts.app', ['title' => 'Staff Directory - Glow FM']);
    }
}
