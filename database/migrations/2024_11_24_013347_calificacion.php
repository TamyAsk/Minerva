<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('calificacion_libros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('calificacion', 5, 2); // Permite guardar decimales con 5 dígitos, 2 de ellos después del punto
            $table->unsignedBigInteger('fk_libros');
            $table->unsignedBigInteger('usuario_id');
            $table->timestamps();
    
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('fk_libros')->references('pk_libros')->on('libros')->onDelete('cascade');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
