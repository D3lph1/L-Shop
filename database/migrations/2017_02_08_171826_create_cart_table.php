<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('server');
            $table->string('player');
            $table->string('type', 16);
            $table->string('item');
            $table->integer('amount');
            $table->text('extra')->nullable()->default(null);
            $table->integer('item_id');
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->index('player');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cart');
    }
}
