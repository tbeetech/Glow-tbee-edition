<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff_members', function (Blueprint $table) {
            $table->foreignId('department_id')->nullable()->after('department')->constrained('team_departments')->nullOnDelete();
            $table->foreignId('team_role_id')->nullable()->after('department_id')->constrained('team_roles')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('staff_members', function (Blueprint $table) {
            $table->dropConstrainedForeignId('department_id');
            $table->dropConstrainedForeignId('team_role_id');
        });
    }
};
