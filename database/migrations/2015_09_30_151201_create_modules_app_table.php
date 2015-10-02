<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesAppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules_app', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('module_id')->unsigned()->index();
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('modules_app_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('modules_app_id')->unsigned();
            $table->string('locale')->index();

            $table->string('title');

            $table->unique(['modules_app_id','locale']);
            $table->foreign('modules_app_id')->references('id')->on('modules_app')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('modules_app_translations');
        Schema::drop('modules_app');
    }
}
