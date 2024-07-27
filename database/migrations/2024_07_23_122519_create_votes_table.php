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
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key to users table
            $table->foreignId('post_id')->constrained('user_posts')->onDelete('cascade'); // Foreign key to posts table
            $table->enum('vote_type', ['positive', 'negative']); // VoteModel type column
            $table->timestamps();
            $table->unique(['user_id', 'post_id']); // Ensure a user can only vote once per post
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
