<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyTagsTableAddAutoIncrementToId extends Migration
{
    public function up()
    {
        // Drop foreign key constraints that reference the `id` column in the `tags` table
        Schema::table('post_tags', function (Blueprint $table) {
            $table->dropForeign(['tag_id']); // Replace with actual foreign key name
        });

        // Drop primary key constraint and id column if exists
        Schema::table('tags', function (Blueprint $table) {
            $table->dropPrimary('id'); // Drop primary key constraint if exists
            $table->dropColumn('id'); // Drop id column if exists
        });

        // Add id column with auto-increment primary key
        Schema::table('tags', function (Blueprint $table) {
            $table->bigIncrements('id'); // Add id column as auto-increment primary key
        });

        // Add back foreign key constraints
        Schema::table('post_tags', function (Blueprint $table) {
            $table->foreign('tag_id') // Replace with actual foreign key name
                ->references('id')->on('tags')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        // Drop foreign key constraints that reference the `id` column in the `tags` table
        Schema::table('post_tags', function (Blueprint $table) {
            $table->dropForeign(['tag_id']); // Replace with actual foreign key name
        });

        // Drop id column
        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn('id');
        });

        // Recreate id column as primary key
        Schema::table('tags', function (Blueprint $table) {
            $table->bigIncrements('id')->first(); // Add id column as auto-increment primary key
        });

        // Add back foreign key constraints
        Schema::table('post_tags', function (Blueprint $table) {
            $table->foreign('tag_id') // Replace with actual foreign key name
                ->references('id')->on('tags')
                ->onDelete('cascade');
        });
    }
}
