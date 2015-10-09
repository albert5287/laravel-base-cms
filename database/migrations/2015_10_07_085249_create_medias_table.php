<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medias', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('media_type_id')->unsigned()->index();
            $table->integer('application_id')->unsigned()->index();
            $table->string('file_name');
            $table->string('url');
            $table->boolean('trash')->default(false);
            $table->timestamps();

            $table->foreign('media_type_id')
                ->references('id')
                ->on('media_types')
                ->onDelete('cascade');

            $table->foreign('application_id')
                ->references('id')
                ->on('applications')
                ->onDelete('cascade');
        });

        Schema::create('media_translations', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();;
            $table->integer('media_id')->unsigned()->index();
            $table->string('locale')->index();

            $table->string('title');
            $table->text('description');

            $table->unique(['media_id','locale']);
            $table->foreign('media_id')->references('id')->on('medias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('media_translations');
        Schema::drop('medias');
    }
}
