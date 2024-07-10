<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {  
        if (Schema::hasTable('tags')) {
            Schema::drop('tags');
        }

        Schema::create('tags', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('tag_name');
            $table->unsignedBigInteger('post_id');

            // Foreign key constraint
            $table->foreign('post_id')->references('id')->on('user_posts')->onDelete('cascade');
            
            // Composite primary key
            $table->primary(['id', 'post_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('tags');
    }
};
