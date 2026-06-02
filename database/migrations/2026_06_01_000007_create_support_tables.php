<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->references('id')->on('comments')->cascadeOnDelete();
            $table->string('author_name');
            $table->string('author_email');
            $table->text('body');
            $table->boolean('is_approved')->default(false);
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->index(['topic_id', 'is_approved']);
        });

        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained()->cascadeOnDelete();
            $table->string('session_id');
            $table->timestamps();

            $table->unique(['topic_id', 'session_id']);
        });

        Schema::create('topic_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained()->cascadeOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->string('session_id')->nullable();
            $table->timestamp('viewed_at');

            $table->index(['topic_id', 'viewed_at']);
        });

        Schema::create('search_trends', function (Blueprint $table) {
            $table->id();
            $table->string('query');
            $table->unsignedBigInteger('count')->default(1);
            $table->timestamps();

            $table->unique('query');
        });

        Schema::create('static_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('static_page_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('static_page_id')->constrained()->cascadeOnDelete();
            $table->string('locale', 5);
            $table->string('title');
            $table->longText('content');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->unique(['static_page_id', 'locale']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('static_page_translations');
        Schema::dropIfExists('static_pages');
        Schema::dropIfExists('search_trends');
        Schema::dropIfExists('topic_views');
        Schema::dropIfExists('bookmarks');
        Schema::dropIfExists('comments');
    }
};
