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
        Schema::create('module_applications', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('application_id')->unsigned()->index();
            $table->foreign('application_id')
                ->references('id')
                ->on('applications')
                ->onDelete('cascade');

            $table->integer('module_id')->unsigned()->index();
            $table->foreign('module_id')
                ->references('id')
                ->on('modules')
                ->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('module_application_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('module_application_id')->unsigned();
            $table->string('locale')->index();

            $table->string('name');

            $table->unique(['module_application_id','locale']);
            $table->foreign('module_application_id')
                ->references('id')
                ->on('module_applications')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('module_application_translations');
        Schema::drop('module_applications');
    }
}
