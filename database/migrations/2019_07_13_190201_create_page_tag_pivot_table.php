<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageTagPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function () {
            Schema::create('page_tag', function (Blueprint $table) {

                // create page_id
                $table->bigInteger('page_id')
                ->unsigned()
                ->nullable();

                // make page_id column a foreign key
                $table->foreign('page_id')
                ->references('id')
                ->on('pages')
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
        Schema::dropIfExists('page_tag');
    }
}
