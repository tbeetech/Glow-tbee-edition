<?php

namespace App\Livewire\Admin\Ads;

use App\Models\Ads\Ad;
use Livewire\Component;

class Form extends Component
{
    public $adId = null;
    public $isEditing = false;

    public $name = '';
    public $placement = 'global';
    public $type = 'image';
    public $image_url = '';
    public $html = '';
    public $link_url = '';
    public $button_text = '';
    public $priority = 0;
    public $is_active = true;
    public $starts_at = '';
    public $ends_at = '';

    protected $rules = [
        'name' => 'required|min:3|max:255',
        'placement' => 'required',
        'type' => 'required|in:image,html',
        'image_url' => 'nullable|url',
        'html' => 'nullable|string',
        'link_url' => 'nullable|url',
        'button_text' => 'nullable|max:50',
        'priority' => 'nullable|integer|min:0',
        'is_active' => 'boolean',
        'starts_at' => 'nullable|date',
        'ends_at' => 'nullable|date|after_or_equal:starts_at',
    ];

    public function mount($adId = null)
    {
        if ($adId) {
            $ad = Ad::findOrFail($adId);
            $this->adId = $ad->id;
            $this->isEditing = true;
            $this->name = $ad->name;
            $this->placement = $ad->placement;
            $this->type = $ad->type;
            $this->image_url = $ad->image_url;
            $this->html = $ad->html;
            $this->link_url = $ad->link_url;
            $this->button_text = $ad->button_text;
            $this->priority = $ad->priority;
            $this->is_active = $ad->is_active;
            $this->starts_at = $ad->starts_at?->format('Y-m-d\TH:i') ?? '';
            $this->ends_at = $ad->ends_at?->format('Y-m-d\TH:i') ?? '';
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'placement' => $this->placement,
            'type' => $this->type,
            'image_url' => $this->type === 'image' ? $this->image_url : null,
            'html' => $this->type === 'html' ? $this->html : null,
            'link_url' => $this->link_url,
            'button_text' => $this->button_text,
            'priority' => $this->priority ?? 0,
            'is_active' => $this->is_active,
            'starts_at' => $this->starts_at ?: null,
            'ends_at' => $this->ends_at ?: null,
        ];

        if ($this->isEditing) {
            Ad::findOrFail($this->adId)->update($data);
            $message = 'Ad updated successfully.';
        } else {
            Ad::create($data);
            $message = 'Ad created successfully.';
        }

        return redirect()->route('admin.ads.index')->with('success', $message);
    }

    public function render()
    {
        return view('livewire.admin.ads.form')
            ->layout('layouts.admin', ['header' => $this->isEditing ? 'Edit Ad' : 'Create Ad']);
    }
}
