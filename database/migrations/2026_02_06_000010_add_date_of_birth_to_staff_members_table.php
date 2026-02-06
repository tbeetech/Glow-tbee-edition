<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('staff_members', function (Blueprint $table) {
            $table->date('date_of_birth')->nullable()->after('joined_date');
            $table->index('date_of_birth');
        });
    }

    public function down(): void
    {
        Schema::table('staff_members', function (Blueprint $table) {
            $table->dropIndex(['date_of_birth']);
            $table->dropColumn('date_of_birth');
        });
    }
};
