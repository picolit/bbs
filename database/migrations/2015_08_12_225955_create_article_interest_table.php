<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleInterestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_interest', function (Blueprint $table) {
            $table->integer('article_id')->unsigned()->references('id')->on('articles')->onAction();
            $table->integer('interest_id')->unsigned()->references('id')->on('interests')->onAction();
            $table->primary(['article_id', 'interest_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_interest');
    }
}
