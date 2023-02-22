<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('id_transaksi')->primary()->unique();
            $table->string('status');
            $table->unsignedBigInteger('member_id')->nullable();
            $table->string('nama')->nullable();
            $table->unsignedBigInteger('playstation_id');
            $table->string('harga');
            $table->string('jam_main');
            $table->string('total');
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('playstation_id')->references('id')->on('playstations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
