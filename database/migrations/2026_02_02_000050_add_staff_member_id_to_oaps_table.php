<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('oaps', function (Blueprint $table) {
            $table->foreignId('staff_member_id')
                ->nullable()
                ->after('id')
                ->constrained('staff_members')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('oaps', function (Blueprint $table) {
            $table->dropConstrainedForeignId('staff_member_id');
        });
    }
};
