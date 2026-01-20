<?php

namespace App\Livewire\Admin\Team;

use App\Models\Show\OAP;
use App\Models\Team\Department;
use App\Models\Team\Role as TeamRole;
use App\Support\CloudinaryUploader;
use Illuminate\Support\Str;
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
    public $voice_sample_url = '';
    public $specializations = '';
    public $email = '';
    public $department_id = '';
    public $team_role_id = '';
    public $phone = '';
    public $employment_status = 'full-time';
    public $is_active = true;
    public $available = true;
    public $joined_date = '';
    public $departments = [];
    public $teamRoles = [];

    public $social_media = [
        'facebook' => '',
        'twitter' => '',
        'instagram' => '',
        'tiktok' => '',
        'linkedin' => '',
        'youtube' => '',
    ];

    protected $rules = [
        'name' => 'required|min:3|max:255',
        'bio' => 'required|min:10',
        'profile_photo' => 'nullable|url',
        'profile_photo_upload' => 'nullable|image|max:5120',
        'voice_sample_url' => 'nullable|url',
        'email' => 'nullable|email',
        'department_id' => 'required|exists:team_departments,id',
        'team_role_id' => 'required|exists:team_roles,id',
        'joined_date' => 'nullable|date',
        'employment_status' => 'required',
        'is_active' => 'boolean',
        'available' => 'boolean',
    ];

    public function mount($oapId = null)
    {
        $this->departments = Department::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        if ($oapId) {
            $oap = OAP::findOrFail($oapId);
            $this->oapId = $oap->id;
            $this->isEditing = true;
            $this->name = $oap->name;
            $this->bio = $oap->bio;
            $this->profile_photo = $oap->profile_photo;
            $this->voice_sample_url = $oap->voice_sample_url;
            $this->specializations = $oap->specializations ? implode(', ', $oap->specializations) : '';
            $this->email = $oap->email;
            $this->department_id = $oap->department_id;
            $this->team_role_id = $oap->team_role_id;
            $this->phone = $oap->phone;
            $this->employment_status = $oap->employment_status;
            $this->is_active = $oap->is_active;
            $this->available = $oap->available;
            $this->joined_date = $oap->joined_date?->format('Y-m-d') ?? '';
            $this->social_media = $oap->social_media ?? $this->social_media;
        }

        $this->teamRoles = TeamRole::query()
            ->where('is_active', true)
            ->when($this->department_id, function ($query) {
                $query->where('department_id', $this->department_id);
            })
            ->orderBy('name')
            ->get();
    }

    public function updatedDepartmentId()
    {
        $this->team_role_id = '';
        $this->teamRoles = TeamRole::query()
            ->where('is_active', true)
            ->where('department_id', $this->department_id)
            ->orderBy('name')
            ->get();
    }

    public function save()
    {
        $this->validate();

        $validRole = TeamRole::query()
            ->where('id', $this->team_role_id)
            ->where('department_id', $this->department_id)
            ->exists();

        if (!$validRole) {
            $this->addError('team_role_id', 'Selected role does not belong to the chosen department.');
            return;
        }

        $slug = Str::slug($this->name);
        $slugExists = OAP::where('slug', $slug)
            ->when($this->isEditing, function ($query) {
                $query->where('id', '!=', $this->oapId);
            })
            ->exists();

        if ($slugExists) {
            $this->addError('name', 'An OAP with a similar name already exists.');
            return;
        }

        $photoPath = $this->profile_photo;
        if ($this->profile_photo_upload) {
            $photoPath = CloudinaryUploader::uploadImage($this->profile_photo_upload, 'oaps/photos');
        }

        $data = [
            'name' => $this->name,
            'slug' => $slug,
            'bio' => $this->bio,
            'profile_photo' => $photoPath,
            'voice_sample_url' => $this->voice_sample_url,
            'specializations' => !empty($this->specializations)
                ? array_map('trim', explode(',', $this->specializations))
                : null,
            'email' => $this->email,
            'department_id' => $this->department_id,
            'team_role_id' => $this->team_role_id,
            'phone' => $this->phone,
            'employment_status' => $this->employment_status,
            'is_active' => $this->is_active,
            'available' => $this->available,
            'joined_date' => $this->joined_date ?: null,
            'social_media' => $this->social_media,
        ];

        if ($this->isEditing) {
            OAP::findOrFail($this->oapId)->update($data);
            $message = 'OAP updated successfully.';
        } else {
            OAP::create($data);
            $message = 'OAP created successfully.';
        }

        return redirect()->route('admin.team.oaps')->with('success', $message);
    }

    public function render()
    {
        return view('livewire.admin.team.oap-form')
            ->layout('layouts.admin', [
                'header' => $this->isEditing ? 'Edit OAP' : 'Add OAP',
            ]);
    }
}
