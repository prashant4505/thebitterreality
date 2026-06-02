<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('timelines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained()->cascadeOnDelete();
            $table->string('slug');
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->unique(['topic_id', 'slug']);
        });

        Schema::create('timeline_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('timeline_id')->constrained()->cascadeOnDelete();
            $table->string('date_label');   // "753 BC", "1947", "March 15, 44 BC"
            $table->integer('sort_order')->default(0);
            $table->string('image')->nullable();
            $table->string('type')->default('event'); // event, milestone, turning_point, discovery
            $table->timestamps();

            $table->index(['timeline_id', 'sort_order']);
        });

        Schema::create('timeline_entry_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('timeline_entry_id')->constrained()->cascadeOnDelete();
            $table->string('locale', 5);
            $table->string('title');
            $table->text('description')->nullable();
            $table->unique(['timeline_entry_id', 'locale']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timeline_entry_translations');
        Schema::dropIfExists('timeline_entries');
        Schema::dropIfExists('timelines');
    }
};
