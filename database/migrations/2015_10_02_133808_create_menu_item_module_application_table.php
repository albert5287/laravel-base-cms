<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemModuleApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_item_module_application', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('menu_item_id')->unsigned()->index();
            $table->foreign('menu_item_id')->references('id')->on('menu_items')->onDelete('cascade');

            $table->integer('module_application_id')->unsigned()->index();
            $table->foreign('module_application_id')->references('id')->on('module_applications')->onDelete('cascade');

            $table->integer('sort')->unsigned();
            $table->boolean('enabled')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('menu_item_module_application');
    }
}
