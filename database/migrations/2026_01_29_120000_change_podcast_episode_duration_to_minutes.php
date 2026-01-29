<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE podcast_episodes MODIFY duration DECIMAL(8,2) NULL');
        DB::statement('UPDATE podcast_episodes SET duration = ROUND(duration / 60, 2) WHERE duration IS NOT NULL');
    }

    public function down(): void
    {
        DB::statement('UPDATE podcast_episodes SET duration = ROUND(duration * 60) WHERE duration IS NOT NULL');
        DB::statement('ALTER TABLE podcast_episodes MODIFY duration INT UNSIGNED NOT NULL DEFAULT 0');
    }
};
