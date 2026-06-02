<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('historical_figures', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('featured_image')->nullable();
            $table->string('born')->nullable();       // e.g. "350 BC"
            $table->string('died')->nullable();       // e.g. "283 BC"
            $table->string('era')->nullable();        // e.g. "Ancient India"
            $table->string('region')->nullable();     // e.g. "India"
            $table->string('category')->nullable();   // Statesman, Scientist, Philosopher, etc.
            $table->boolean('is_published')->default(true);
            $table->unsignedBigInteger('view_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('historical_figure_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('historical_figure_id')->constrained()->cascadeOnDelete();
            $table->string('locale', 5);
            $table->string('name');
            $table->string('title')->nullable();       // "Emperor", "Philosopher", etc.
            $table->text('short_bio')->nullable();
            $table->longText('full_bio')->nullable();
            $table->text('achievements')->nullable();  // Rich text
            $table->json('quotes')->nullable();        // [string]
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->unique(['historical_figure_id', 'locale'], 'hft_figure_locale_unique');
            $table->timestamps();
        });

        // Topics ↔ Historical Figures pivot
        Schema::create('topic_figures', function (Blueprint $table) {
            $table->foreignId('topic_id')->constrained()->cascadeOnDelete();
            $table->foreignId('historical_figure_id')->constrained()->cascadeOnDelete();
            $table->string('role')->nullable();  // "Central Figure", "Antagonist", "Reformer", etc.
            $table->primary(['topic_id', 'historical_figure_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topic_figures');
        Schema::dropIfExists('historical_figure_translations');
        Schema::dropIfExists('historical_figures');
    }
};
