<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->date('date');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('news_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('news_id')->unsigned();
            $table->string('locale')->index();
            $table->boolean('status')->default(0);
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('summary');
            $table->text('body');
            $table->timestamps();
            $table->unique(['news_id', 'locale']);
            $table->unique(['locale', 'slug']);
            $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('news_translations');
        Schema::drop('news');
    }
}
