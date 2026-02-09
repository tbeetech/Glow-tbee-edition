<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'department_id',
        'team_role_id',
        'avatar',
        'bio',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public const STAFF_LIKE_ROLES = ['staff', 'corp_member', 'intern'];

    // Role helper methods
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isStaff(): bool
    {
        return in_array($this->role, self::STAFF_LIKE_ROLES, true);
    }

    public function isDj(): bool
    {
        return $this->isStaff();
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function hasRole(string $role): bool
    {
        if ($role === 'staff') {
            return $this->isStaff();
        }

        return $this->role === $role;
    }

    public function hasAnyRole(array $roles): bool
    {
        if (in_array('staff', $roles, true) && $this->isStaff()) {
            return true;
        }

        return in_array($this->role, $roles, true);
    }

    public function getRoleLabelAttribute(): string
    {
        $role = $this->role ?? 'user';

        return (string) Str::of($role)->replace('_', ' ')->title();
    }

    public function department()
    {
        return $this->belongsTo(\App\Models\Team\Department::class, 'department_id');
    }

    public function teamRole()
    {
        return $this->belongsTo(\App\Models\Team\Role::class, 'team_role_id');
    }

    public function staffMember()
    {
        return $this->hasOne(\App\Models\Staff\StaffMember::class, 'user_id');
    }

    public function getDefaultGuardName(): string
    {
        return config('auth.defaults.guard', 'web');
    }
}
