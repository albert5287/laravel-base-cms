<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('class');
            $table->string('name');
            $table->boolean('enabled')->default(true);
            $table->timestamps();
        });

        Schema::create('module_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('module_id')->unsigned();
            $table->string('locale')->index();

            $table->string('title');

            $table->unique(['module_id','locale']);
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('module_translations');
        Schema::drop('modules');
    }
}
