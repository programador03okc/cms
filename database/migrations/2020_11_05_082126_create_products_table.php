<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin.products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('part_number', 50);
            $table->string('sku', 50);
            $table->text('name')->nullable();
            $table->text('title')->nullable();
            $table->text('subtitle')->nullable();
            $table->text('slug_large')->nullable();
            $table->text('slug_short')->nullable();
            $table->text('model')->nullable();
            $table->integer('category_id')->unsigned();
            $table->integer('subcategory_id')->unsigned()->nullable();
            $table->integer('mark_id')->unsigned();
            $table->integer('unit_id')->unsigned();
            $table->text('detail')->nullable();
            $table->text('link')->nullable();
            $table->enum('status', ['CREADO', 'DISEÑADO'])->default('CREADO');
            $table->decimal('stock', 9, 2)->default('0.00');
            $table->decimal('stock_reserv', 9, 2)->default('0.00');
            $table->decimal('cost', 9, 2)->default('0.00');
            $table->integer('user_id')->unsigned();
            $table->integer('correlative')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('mark_id')->references('id')->on('admin.marks')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('category_id')->references('id')->on('admin.categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('subcategory_id')->references('id')->on('admin.subcategories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('unit_id')->references('id')->on('admin.units')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('admin.products');
    }
}
