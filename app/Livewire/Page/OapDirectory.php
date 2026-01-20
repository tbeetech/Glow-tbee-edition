<?php

namespace App\Livewire\Page;

use App\Models\Show\OAP;
use Livewire\Component;
use Livewire\WithPagination;

class OapDirectory extends Component
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

    public function getOapsProperty()
    {
        return OAP::active()
            ->with(['department', 'teamRole'])
            ->when($this->searchQuery, function ($q) {
                $q->where('name', 'like', "%{$this->searchQuery}%")
                  ->orWhere('bio', 'like', "%{$this->searchQuery}%")
                  ->orWhereHas('department', function ($dept) {
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
        return view('livewire.page.oap-directory', [
            'oaps' => $this->oaps,
        ])->layout('layouts.app', ['title' => 'OAP Directory - Glow FM']);
    }
}
