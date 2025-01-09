<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categoria_as_libros', function (Blueprint $table) {
            $table->id('pk_categoria_as_libros');
            $table->unsignedBigInteger('fk_libros');
            $table->unsignedBigInteger('fk_categoria_libros');
            $table->timestamps();
            
            $table->foreign('fk_libros')->references('pk_libros')->on('libros')->onDelete('cascade');
            $table->foreign('fk_categoria_libros')->references('pk_categoria_libros')->on('categoria_libros')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('categoria_as_libros');
    }
};
