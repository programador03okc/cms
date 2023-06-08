<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin.prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('business_type_id')->unsigned();
            $table->integer('store_shop_id')->unsigned()->nullable();
            $table->integer('product_id')->unsigned();
            $table->integer('currency_id')->unsigned();
            $table->decimal('cost', 9, 2)->nullable();
            $table->decimal('margin', 9, 2)->nullable();
            $table->decimal('discount', 9, 2)->nullable();
            $table->decimal('price', 9, 2);
            $table->enum('status', ['VENTA', 'OFERTA', 'PROMOCION'])->default('VENTA');
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('business_type_id')->references('id')->on('admin.business_types')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('store_shop_id')->references('id')->on('admin.store_shops')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('admin.prices');
    }
}
