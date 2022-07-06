<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMejasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mejas', function (Blueprint $table) {
            $table->id();
            $table->string('no_meja');

            $table->enum('status', [0,1])->default(1); // 1 untuk tersedia 0 untuk tidak tersedia

            $table->unsignedBigInteger('type_meja_id');
            $table->foreign('type_meja_id')->references('id')->on('type_mejas')->onDelete('cascade');

            $table->unsignedBigInteger('hal_meja_id');
            $table->foreign('hal_meja_id')->references('id')->on('type_halaman_mejas')->onDelete('cascade');
            
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
        Schema::dropIfExists('mejas');
    }
}
