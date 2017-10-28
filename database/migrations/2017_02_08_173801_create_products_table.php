<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->float('price')->unsigned();
            $table->integer('item_id');
            $table->integer('server_id');
            $table->integer('stack');
            $table->integer('category_id');
            $table->float('sort_priority')->default(0);
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->index(['item_id', 'server_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
