<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProjectsPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function () {
            Schema::create('project_user', function (Blueprint $table) {

                // create project_id
                $table->bigInteger('project_id')
                ->unsigned()
                ->nullable();

                // make article_id column a foreign key
                $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('cascade');

                // create user_id column
                $table->bigInteger('user_id')
                ->unsigned()
                ->nullable();

                // make user_id column a foreign key
                $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('project_user');
    }
}
