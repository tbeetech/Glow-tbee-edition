<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->string('approval_status')->default('pending')->after('is_published');
            $table->text('approval_reason')->nullable()->after('approval_status');
            $table->foreignId('reviewed_by')->nullable()->after('approval_reason')
                ->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
        });

        Schema::table('news', function (Blueprint $table) {
            $table->string('approval_status')->default('pending')->after('is_published');
            $table->text('approval_reason')->nullable()->after('approval_status');
            $table->foreignId('reviewed_by')->nullable()->after('approval_reason')
                ->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->string('approval_status')->default('pending')->after('is_published');
            $table->text('approval_reason')->nullable()->after('approval_status');
            $table->foreignId('reviewed_by')->nullable()->after('approval_reason')
                ->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
        });

        Schema::table('podcast_episodes', function (Blueprint $table) {
            $table->string('approval_status')->default('pending')->after('status');
            $table->text('approval_reason')->nullable()->after('approval_status');
            $table->foreignId('reviewed_by')->nullable()->after('approval_reason')
                ->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
        });

        DB::table('blog_posts')->update(['approval_status' => 'approved']);
        DB::table('news')->update(['approval_status' => 'approved']);
        DB::table('events')->update(['approval_status' => 'approved']);
        DB::table('podcast_episodes')->update(['approval_status' => 'approved']);
    }

    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('reviewed_by');
            $table->dropColumn(['approval_status', 'approval_reason', 'reviewed_at']);
        });

        Schema::table('news', function (Blueprint $table) {
            $table->dropConstrainedForeignId('reviewed_by');
            $table->dropColumn(['approval_status', 'approval_reason', 'reviewed_at']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropConstrainedForeignId('reviewed_by');
            $table->dropColumn(['approval_status', 'approval_reason', 'reviewed_at']);
        });

        Schema::table('podcast_episodes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('reviewed_by');
            $table->dropColumn(['approval_status', 'approval_reason', 'reviewed_at']);
        });
    }
};
