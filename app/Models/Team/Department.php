<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Department extends Model
{
    use HasFactory;

    protected $table = 'team_departments';

    protected $fillable = [
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

        static::saving(function ($department) {
            if (empty($department->slug) && !empty($department->name)) {
                $department->slug = Str::slug($department->name);
            }
        });
    }

    public function roles()
    {
        return $this->hasMany(Role::class, 'department_id');
    }
}
