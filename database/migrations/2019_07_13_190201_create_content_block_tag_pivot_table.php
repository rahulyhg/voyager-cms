<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentBlockTagPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function () {
            Schema::create('content_block_tag', function (Blueprint $table) {

                // create content_block_id
                $table->bigInteger('content_block_id')
                ->unsigned()
                ->nullable();

                // make content_block_id column a foreign key
                $table->foreign('content_block_id')
                ->references('id')
                ->on('content_blocks')
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
        Schema::dropIfExists('content_block_tag');
    }
}
