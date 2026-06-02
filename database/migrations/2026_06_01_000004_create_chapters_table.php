<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained()->cascadeOnDelete();
            $table->string('slug');
            $table->integer('sort_order')->default(0);
            $table->string('featured_image')->nullable();
            $table->integer('reading_time')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->unique(['topic_id', 'slug']);
            $table->index(['topic_id', 'sort_order']);
        });

        Schema::create('chapter_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chapter_id')->constrained()->cascadeOnDelete();
            $table->string('locale', 5);
            $table->string('title');
            $table->longText('content');              // Rich HTML content
            $table->text('summary')->nullable();
            $table->json('pull_quotes')->nullable();  // [{quote, source}]
            $table->json('fact_boxes')->nullable();   // [{title, facts:[]}]
            $table->json('key_lessons')->nullable();  // [string]
            $table->json('myths_vs_facts')->nullable(); // [{myth, fact}]
            $table->unique(['chapter_id', 'locale']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chapter_translations');
        Schema::dropIfExists('chapters');
    }
};
