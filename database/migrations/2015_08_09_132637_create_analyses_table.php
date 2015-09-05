<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnalysesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analyses', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('date')->unsigned();
            $table->integer('page_view')->unsigned();
            $table->integer('unique_user_view')->unsigned();
            $table->integer('new_post')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analyses');
    }
}
