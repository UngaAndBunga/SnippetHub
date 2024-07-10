<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTagsTable extends Migration
{
    public function up()
    {
        Schema::create('post_tags', function (Blueprint $table) {
            $table->unsignedBigInteger('tag_id');
            $table->unsignedBigInteger('post_id');
            $table->primary(['tag_id', 'post_id']);
            
            // Foreign keys
            $table->foreign('tag_id')
                ->references('id')->on('tags')
                ->onDelete('cascade');
            
            $table->foreign('post_id')
                ->references('id')->on('user_posts')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('post_tags');
    }
}
