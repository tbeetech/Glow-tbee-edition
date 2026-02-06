<?php

namespace App\Support;

use App\Models\Staff\StaffMember;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class StaffBirthdayTemplate
{
    public static function defaults(): array
    {
        return [
            'subject' => 'Happy Birthday, {first_name}!',
            'message' => "Hi {first_name},\n\nWishing you a wonderful birthday filled with joy and celebration. Thank you for all you do at {station_name}.\n\nHave an amazing day!\n\n— {station_name} Team",
        ];
    }

    public static function placeholders(StaffMember $staff, array $station, Carbon $date): array
    {
        $stationName = (string) ($station['name'] ?? config('app.name', 'Our Station'));
        $stationFrequency = (string) ($station['frequency'] ?? '');
        $firstName = trim((string) Str::of($staff->name ?? '')->explode(' ')->first());
        $firstName = $firstName !== '' ? $firstName : (string) ($staff->name ?? '');
        $role = $staff->teamRole?->name ?? $staff->role ?? 'Team Member';
        $department = $staff->departmentRelation?->name ?? $staff->department ?? 'Team';

        return [
            '{name}' => (string) ($staff->name ?? $firstName),
            '{first_name}' => (string) $firstName,
            '{station_name}' => $stationName,
            '{station_frequency}' => $stationFrequency,
            '{role}' => (string) $role,
            '{department}' => (string) $department,
            '{today}' => $date->format('F j, Y'),
            '{year}' => (string) $date->year,
        ];
    }

    public static function render(string $template, StaffMember $staff, array $station, Carbon $date): string
    {
        return strtr($template, self::placeholders($staff, $station, $date));
    }
}
