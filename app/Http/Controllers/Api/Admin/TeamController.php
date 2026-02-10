<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Show\OAP;
use App\Models\Staff\StaffMember;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function oaps(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $status = $request->query('status', 'all');
        $perPage = (int) $request->query('per_page', 15);
        $perPage = min(50, max(10, $perPage));

        $query = OAP::with(['department', 'teamRole'])
            ->when($search !== '', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('bio', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });

        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        $oaps = $query->orderBy('name')->paginate($perPage);

        $data = $oaps->getCollection()->map(function (OAP $oap) {
            return [
                'id' => $oap->id,
                'name' => $oap->name,
                'slug' => $oap->slug,
                'email' => $oap->email,
                'phone' => $oap->phone,
                'is_active' => (bool) $oap->is_active,
                'department' => $oap->department?->name,
                'role' => $oap->teamRole?->name ?? 'On-Air Personality',
            ];
        })->values();

        return response()->json([
            'data' => $data,
            'meta' => [
                'pagination' => [
                    'current_page' => $oaps->currentPage(),
                    'last_page' => $oaps->lastPage(),
                    'per_page' => $oaps->perPage(),
                    'total' => $oaps->total(),
                ],
            ],
        ]);
    }

    public function staff(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $status = $request->query('status', 'all');
        $perPage = (int) $request->query('per_page', 15);
        $perPage = min(50, max(10, $perPage));

        $query = StaffMember::with(['departmentRelation', 'teamRole'])
            ->when($search !== '', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });

        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        $staff = $query->orderBy('name')->paginate($perPage);

        $data = $staff->getCollection()->map(function (StaffMember $member) {
            return [
                'id' => $member->id,
                'name' => $member->name,
                'slug' => $member->slug,
                'email' => $member->email,
                'phone' => $member->phone,
                'is_active' => (bool) $member->is_active,
                'department' => $member->departmentRelation?->name ?? $member->department,
                'role' => $member->teamRole?->name ?? $member->role ?? 'Staff Member',
            ];
        })->values();

        return response()->json([
            'data' => $data,
            'meta' => [
                'pagination' => [
                    'current_page' => $staff->currentPage(),
                    'last_page' => $staff->lastPage(),
                    'per_page' => $staff->perPage(),
                    'total' => $staff->total(),
                ],
            ],
        ]);
    }
}
