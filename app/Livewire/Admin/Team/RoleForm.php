<?php

namespace App\Livewire\Admin\Team;

use App\Models\Team\Department;
use App\Models\Team\Role;
use Illuminate\Support\Str;
use Livewire\Component;

class RoleForm extends Component
{
    public $roleId = null;
    public $isEditing = false;

    public $department_id = '';
    public $name = '';
    public $description = '';
    public $is_active = true;

    public function mount($roleId = null)
    {
        if ($roleId) {
            $role = Role::findOrFail($roleId);
            $this->roleId = $role->id;
            $this->isEditing = true;
            $this->department_id = $role->department_id;
            $this->name = $role->name;
            $this->description = $role->description;
            $this->is_active = $role->is_active;
        }
    }

    protected function rules()
    {
        $rules = [
            'department_id' => 'required|exists:team_departments,id',
            'name' => 'required|min:2|max:255',
            'description' => 'nullable',
            'is_active' => 'boolean',
        ];

        if ($this->department_id) {
            $rules['name'] = 'required|min:2|max:255|unique:team_roles,name,NULL,id,department_id,' . $this->department_id;
        }

        if ($this->isEditing) {
            $rules['name'] = 'required|min:2|max:255|unique:team_roles,name,' . $this->roleId . ',id,department_id,' . $this->department_id;
        }

        return $rules;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'department_id' => $this->department_id,
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'is_active' => $this->is_active,
        ];

        if ($this->isEditing) {
            Role::findOrFail($this->roleId)->update($data);
            $message = 'Role updated successfully.';
        } else {
            Role::create($data);
            $message = 'Role created successfully.';
        }

        return redirect()->route('admin.team.roles')->with('success', $message);
    }

    public function render()
    {
        return view('livewire.admin.team.role-form', [
            'departments' => Department::query()->orderBy('name')->get(),
        ])->layout('layouts.admin', [
            'header' => $this->isEditing ? 'Edit Role' : 'Add Role',
        ]);
    }
}
