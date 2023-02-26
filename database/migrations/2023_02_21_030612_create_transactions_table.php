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
            $table->unsignedBigInteger('device_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('harga');
            $table->string('jam_main');
            $table->time('waktu_mulai');
            $table->time('waktu_Selesai');
            $table->string('total');
            $table->string('status_transaksi')->nullable();
            $table->timestamps();
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
