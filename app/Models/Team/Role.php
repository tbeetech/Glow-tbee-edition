<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Role extends Model
{
    use HasFactory;

    protected $table = 'team_roles';

    protected $fillable = [
        'department_id',
        'name',
        'slug',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($role) {
            if (empty($role->slug) && !empty($role->name)) {
                $role->slug = Str::slug($role->name);
            }
        });
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
