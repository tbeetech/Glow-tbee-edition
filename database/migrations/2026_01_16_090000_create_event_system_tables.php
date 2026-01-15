<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->default('fas fa-calendar-alt');
            $table->string('color')->default('amber');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('slug');
            $table->index('is_active');
        });

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt');
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->json('gallery')->nullable();

            $table->foreignId('category_id')->constrained('event_categories')->onDelete('cascade');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');

            $table->timestamp('start_at');
            $table->timestamp('end_at')->nullable();
            $table->string('timezone')->nullable();
            $table->string('venue_name')->nullable();
            $table->text('venue_address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('ticket_url')->nullable();
            $table->string('registration_url')->nullable();
            $table->unsignedInteger('capacity')->nullable();
            $table->string('price')->nullable();

            $table->timestamp('published_at')->nullable();
            $table->unsignedBigInteger('views')->default(0);
            $table->unsignedBigInteger('shares')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->boolean('allow_comments')->default(true);

            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->json('tags')->nullable();

            $table->timestamps();

            $table->index('slug');
            $table->index('category_id');
            $table->index('author_id');
            $table->index('is_published');
            $table->index('is_featured');
            $table->index('start_at');
        });

        Schema::create('event_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('comment');
            $table->boolean('is_approved')->default(true);
            $table->boolean('is_pinned')->default(false);
            $table->timestamps();

            $table->index('event_id');
            $table->index('user_id');
            $table->index('is_approved');
        });

        Schema::create('event_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->enum('type', ['view', 'reaction', 'bookmark', 'share']);
            $table->string('value')->nullable();
            $table->text('notes')->nullable();
            $table->string('collection')->nullable();
            $table->text('user_agent')->nullable();
            $table->text('referer')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['event_id', 'type']);
            $table->index(['user_id', 'type']);
            $table->index('ip_address');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_interactions');
        Schema::dropIfExists('event_comments');
        Schema::dropIfExists('events');
        Schema::dropIfExists('event_categories');
    }
};
