<?php

namespace App\Livewire\Admin\Team;

use App\Models\Team\Department;
use Illuminate\Support\Str;
use Livewire\Component;

class DepartmentForm extends Component
{
    public $departmentId = null;
    public $isEditing = false;

    public $name = '';
    public $description = '';
    public $is_active = true;

    protected function rules()
    {
        $rules = [
            'name' => 'required|min:2|max:255|unique:team_departments,name',
            'description' => 'nullable',
            'is_active' => 'boolean',
        ];

        if ($this->isEditing) {
            $rules['name'] = 'required|min:2|max:255|unique:team_departments,name,' . $this->departmentId;
        }

        return $rules;
    }

    public function mount($departmentId = null)
    {
        if ($departmentId) {
            $department = Department::findOrFail($departmentId);
            $this->departmentId = $department->id;
            $this->isEditing = true;
            $this->name = $department->name;
            $this->description = $department->description;
            $this->is_active = $department->is_active;
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'is_active' => $this->is_active,
        ];

        if ($this->isEditing) {
            Department::findOrFail($this->departmentId)->update($data);
            $message = 'Department updated successfully.';
        } else {
            Department::create($data);
            $message = 'Department created successfully.';
        }

        return redirect()->route('admin.team.departments')->with('success', $message);
    }

    public function render()
    {
        return view('livewire.admin.team.department-form')
            ->layout('layouts.admin', [
                'header' => $this->isEditing ? 'Edit Department' : 'Add Department',
            ]);
    }
}
