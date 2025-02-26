<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        // Modify the `category` column to add new categories
        DB::statement("ALTER TABLE posts MODIFY COLUMN category ENUM(
            'Animal Jokes',
            'Dad Jokes',
            'Dark Humor',
            'One-Liner Jokes',
            'Political Jokes',
            'Relationship Jokes',
            'Technology Jokes',
            'Workplace Jokes',
            'Sports Jokes', -- New category
            'Medical Jokes', -- New category
            'School Jokes'  -- New category
        ) NOT NULL");
    }

    public function down()
    {
        // Revert to the previous enum values
        DB::statement("ALTER TABLE posts MODIFY COLUMN category ENUM(
            'Animal Jokes',
            'Dad Jokes',
            'Dark Humor',
            'One-Liner Jokes',
            'Political Jokes',
            'Relationship Jokes',
            'Technology Jokes',
            'Workplace Jokes'
        ) NOT NULL");
    }
};
