<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin.galleries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('art_type_id')->unsigned();
            $table->integer('section_id')->unsigned();
            $table->text('name');
            $table->text('path');
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('art_type_id')->references('id')->on('admin.art_types')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('section_id')->references('id')->on('admin.sections')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('admin.users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin.galleries');
    }
}
