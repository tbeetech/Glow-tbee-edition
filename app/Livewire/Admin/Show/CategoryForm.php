<?php

namespace App\Livewire\Admin\Show;

use App\Models\Show\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class CategoryForm extends Component
{
    public $categoryId = null;
    public $isEditing = false;

    public $name = '';
    public $description = '';
    public $icon = 'fas fa-microphone';
    public $color = 'blue';

    protected $rules = [
        'name' => 'required|min:3|max:255',
        'description' => 'nullable|string',
        'icon' => 'nullable|string|max:255',
        'color' => 'nullable|string|max:255',
    ];

    public function mount($categoryId = null)
    {
        if ($categoryId) {
            $category = Category::findOrFail($categoryId);
            $this->categoryId = $category->id;
            $this->isEditing = true;
            $this->name = $category->name;
            $this->description = $category->description;
            $this->icon = $category->icon;
            $this->color = $category->color;
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'icon' => $this->icon,
            'color' => $this->color,
        ];

        if ($this->isEditing) {
            Category::findOrFail($this->categoryId)->update($data);
            $message = 'Category updated successfully.';
        } else {
            Category::create($data);
            $message = 'Category created successfully.';
        }

        return redirect()
            ->route('admin.shows.categories')
            ->with('success', $message);
    }

    public function render()
    {
        return view('livewire.admin.show.category-form')
            ->layout('layouts.admin', [
                'header' => $this->isEditing ? 'Edit Category' : 'Add Category',
            ]);
    }
}
