<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'group'];

    protected $casts = [
        'value' => 'array',
    ];

    public static function get(string $key, $default = null)
    {
        if (str_contains($key, '.')) {
            [$root, $path] = explode('.', $key, 2);
            $record = static::where('key', $root)->first();
            $value = $record?->value ?? [];

            return data_get($value, $path, $default);
        }

        $record = static::where('key', $key)->first();

        return $record ? $record->value : $default;
    }

    public static function set(string $key, $value, ?string $group = null): self
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );
    }
}
