<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            if (!Schema::hasColumn('news', 'featured_position')) {
                $table->string('featured_position')->default('hero')->after('is_featured');
            }
        });

        DB::table('news')
            ->where('is_featured', true)
            ->where(function ($query) {
                $query->whereNull('featured_position')
                    ->orWhere('featured_position', '');
            })
            ->update(['featured_position' => 'hero']);

        DB::table('news')
            ->where('is_featured', false)
            ->update(['featured_position' => 'none']);
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            if (Schema::hasColumn('news', 'featured_position')) {
                $table->dropColumn('featured_position');
            }
        });
    }
};
