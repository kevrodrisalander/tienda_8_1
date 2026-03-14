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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id('id_cliente'); // equivalente a serial4 NOT NULL
            $table->string('nombre', 100);
            $table->string('correo', 100)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->text('direccion')->nullable();
            $table->timestamp('fecha_registro')->useCurrent()->nullable();

            $table->unsignedBigInteger('id_usuario')->nullable(); // 11/03/2026
            $table->boolean('activo')->default(true); // 11/03/2026

            // FK opcional hacia usuarios
            $table->foreign('id_usuario')->references('id')->on('usuarios')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
