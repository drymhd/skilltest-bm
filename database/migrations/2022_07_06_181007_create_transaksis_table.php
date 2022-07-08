<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();

            $table->string('kd_transaksi')->unique();
            
            $table->string('nama_pembeli');
            $table->date('tgl_transaksi');
            $table->string('phone')->nullable();
            $table->string('token')->nullable();
            $table->string('c_pelanggan');

            $table->unsignedBigInteger('meja_id');
            $table->foreign('meja_id')->references('id')->on('mejas')->onDelete('cascade');

            $table->enum('type_transaksi', ['tunai', 'non tunai']);
            $table->string('alamat')->nullable()->nullable();

            $table->enum('status', [0,1])->default(0); //0 diproses 1 selesai

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
        Schema::dropIfExists('transaksis');
    }
}
