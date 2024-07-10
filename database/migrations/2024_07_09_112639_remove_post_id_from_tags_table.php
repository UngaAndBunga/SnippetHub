<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemovePostIdFromTagsTable extends Migration
{
    public function up()
    {
        Schema::table('tags', function (Blueprint $table) {
            // Drop foreign key
            $table->dropForeign('tags_post_id_foreign');
            
            // Drop column
            $table->dropColumn('post_id');
        });
    }

    public function down()
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id');

            // Add foreign key
            $table->foreign('post_id')
                ->references('id')->on('user_posts')
                ->onDelete('cascade');
        });
    }
}
