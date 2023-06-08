<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin.price_costs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->integer('currency_id')->unsigned();
            $table->decimal('cost', 9, 2);
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_id')->references('id')->on('admin.products')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('currency_id')->references('id')->on('admin.currencies')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('admin.price_costs');
    }
}
