<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('res_id')->unsigned();
            $table->string('name', 16);
            $table->integer('age');
            $table->integer('sex');
            $table->integer('prefectures');
            $table->string('title', 50);
            $table->string('body', 1024);
            $table->string('mail', 32);
            $table->string('password',16)->nullable();
            $table->string(('ip_address'));
            $table->smallInteger('checked');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
