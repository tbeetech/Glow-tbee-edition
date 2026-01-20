<?php

namespace App\Livewire\Admin\Show;

use App\Models\Show\OAP;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class OapForm extends Component
{
    use WithFileUploads;

    public $oapId = null;
    public $isEditing = false;

    public $name = '';
    public $bio = '';
    public $profile_photo = '';
    public $profile_photo_upload;
    public $specializations = '';
    public $email = '';
    public $phone = '';

    protected $rules = [
        'name' => 'required|min:3|max:255',
        'bio' => 'required|min:10',
        'profile_photo' => 'nullable|url',
        'profile_photo_upload' => 'nullable|image|max:5120',
        'specializations' => 'nullable|string',
        'email' => 'nullable|email',
        'phone' => 'nullable|string|max:50',
    ];

    public function mount($oapId = null)
    {
        if ($oapId) {
            $oap = OAP::findOrFail($oapId);
            $this->oapId = $oap->id;
            $this->isEditing = true;
            $this->name = $oap->name;
            $this->bio = $oap->bio;
            $this->profile_photo = $oap->profile_photo;
            $this->specializations = $oap->specializations ? implode(', ', $oap->specializations) : '';
            $this->email = $oap->email;
            $this->phone = $oap->phone;
        }
    }

    public function save()
    {
        $this->validate();

        $photoPath = $this->profile_photo;
        if ($this->profile_photo_upload) {
            $path = $this->profile_photo_upload->store('oaps/photos', 'public');
            $photoPath = Storage::url($path);
        }

        $data = [
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'bio' => $this->bio,
            'profile_photo' => $photoPath,
            'specializations' => !empty($this->specializations)
                ? array_map('trim', explode(',', $this->specializations))
                : null,
            'email' => $this->email,
            'phone' => $this->phone,
        ];

        if ($this->isEditing) {
            OAP::findOrFail($this->oapId)->update($data);
            $message = 'OAP updated successfully.';
        } else {
            OAP::create($data);
            $message = 'OAP created successfully.';
        }

        return redirect()
            ->route('admin.shows.oaps')
            ->with('success', $message);
    }

    public function render()
    {
        return view('livewire.admin.show.oap-form')
            ->layout('layouts.admin', [
                'header' => $this->isEditing ? 'Edit OAP' : 'Add OAP',
            ]);
    }
}
