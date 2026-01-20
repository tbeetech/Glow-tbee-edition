<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('newsletter_subscriptions', function (Blueprint $table) {
            $table->string('confirm_token')->nullable()->after('source');
            $table->timestamp('confirmed_at')->nullable()->after('confirm_token');
            $table->string('unsubscribe_token')->nullable()->after('confirmed_at');
        });
    }

    public function down(): void
    {
        Schema::table('newsletter_subscriptions', function (Blueprint $table) {
            $table->dropColumn(['confirm_token', 'confirmed_at', 'unsubscribe_token']);
        });
    }
};
