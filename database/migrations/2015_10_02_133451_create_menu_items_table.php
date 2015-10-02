<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('menu_id')->unsigned()->index();
            $table->boolean('enabled')->default(true);
            $table->integer('id_parent')->unsigned()->index();
            $table->integer('sort')->unsigned();
            $table->timestamps();

            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
        });

        Schema::create('menu_item_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('menu_item_id')->unsigned();
            $table->string('locale')->index();

            $table->string('name');

            $table->unique(['menu_item_id','locale']);
            $table->foreign('menu_item_id')->references('id')->on('menu_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('menu_item_translations');
        Schema::drop('menu_items');
    }
}
