<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('featured_image')->nullable();
            $table->string('era')->nullable();         // e.g. "Ancient", "Medieval", "Modern"
            $table->string('region')->nullable();       // e.g. "India", "Europe", "Global"
            $table->string('difficulty')->default('intermediate'); // beginner, intermediate, advanced
            $table->integer('reading_time')->default(0); // minutes
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->unsignedBigInteger('view_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_published', 'is_featured']);
            $table->index(['category_id', 'is_published']);
        });

        Schema::create('topic_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained()->cascadeOnDelete();
            $table->string('locale', 5);
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('overview')->nullable();   // Rich intro before chapters
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('keywords')->nullable();
            $table->unique(['topic_id', 'locale']);
            $table->fullText(['title', 'excerpt', 'overview']);
            $table->timestamps();
        });

        Schema::create('topic_tags', function (Blueprint $table) {
            $table->foreignId('topic_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['topic_id', 'tag_id']);
        });

        // Knowledge graph — related topics
        Schema::create('topic_relations', function (Blueprint $table) {
            $table->foreignId('topic_id')->constrained()->cascadeOnDelete();
            $table->foreignId('related_topic_id')->references('id')->on('topics')->cascadeOnDelete();
            $table->string('relation_type')->default('related'); // related, preceded_by, influenced
            $table->primary(['topic_id', 'related_topic_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topic_relations');
        Schema::dropIfExists('topic_tags');
        Schema::dropIfExists('topic_translations');
        Schema::dropIfExists('topics');
    }
};
