<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id')->unsigned();
            $table->integer('module_application_id')->unsigned()->index();
            $table->boolean('draft')->default(true);
            $table->boolean('trash')->default(false);
            $table->string('featured_image');
            $table->timestamps();

            $table->foreign('module_application_id')->references('id')->on('module_applications')->onDelete('cascade');
        });

        Schema::create('new_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('news_id')->unsigned();
            $table->string('locale')->index();

            $table->string('title');
            $table->string('subtitle');
            $table->text('text');

            $table->unique(['news_id','locale']);
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
        Schema::drop('new_translations');
        Schema::drop('news');
    }
}
