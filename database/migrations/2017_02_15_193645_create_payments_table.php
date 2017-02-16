<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('service')->nullable()->default(null);
            $table->text('products')->nullable()->default(null);
            $table->double('cost')->nullable()->default(null);
            $table->integer('user_id')->nullable()->default(null);
            $table->string('username')->nullable()->default(null);
            $table->integer('server_id')->nullable();
            $table->ipAddress('ip');
            $table->boolean('complete')->default(0);
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->index(['user_id', 'server_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('payments');
    }
}
