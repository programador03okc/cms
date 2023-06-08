<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeatureValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin.feature_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('feature_id')->unsigned();
            $table->integer('value_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('feature_id')->references('id')->on('admin.features')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('value_id')->references('id')->on('admin.values')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin.feature_values');
    }
}
