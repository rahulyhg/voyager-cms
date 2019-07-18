<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTagPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function () {
            Schema::create('post_tag', function (Blueprint $table) {

                // create post_id
                $table->bigInteger('post_id')
                ->unsigned()
                ->nullable();

                // make post_id column a foreign key
                $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onDelete('cascade');

                // create tag_id column
                $table->bigInteger('tag_id')
                ->unsigned()
                ->nullable();

                // make tag_id column a foreign key
                $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->onDelete('cascade');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_tag');
    }
}
