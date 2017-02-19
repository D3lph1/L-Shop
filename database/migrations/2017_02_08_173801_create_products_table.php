<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('price')->unsigned();
            $table->integer('item_id');
            $table->integer('server_id');
            $table->integer('category_id');
            $table->integer('stack');
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
        Schema::drop('goods');
    }
}
