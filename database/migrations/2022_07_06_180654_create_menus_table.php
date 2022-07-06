<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();

            $table->string('nama');
            $table->bigInteger('harga');
            
            $table->enum('status', [0,1])->default(1); //1 untuk tersedia 0 untuk tidak tersedia

            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('type_menus')->onDelete('cascade');

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
        Schema::dropIfExists('menus');
    }
}
