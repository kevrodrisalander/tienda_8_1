<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('pedidos', function (Blueprint $table) {
    $table->id('id_pedido');
    $table->unsignedBigInteger('id_cliente');
    $table->timestamp('fecha_pedido')->useCurrent();
    $table->string('estado', 30)->default('pendiente');

    // 🛠️ CORRECCIÓN: Cambiamos "id" por "id_cliente" en el ->references()
    $table->foreign('id_cliente')
          ->references('id_cliente') // <-- Apunta al nombre real en tu tabla clientes
          ->on('clientes')
          ->onDelete('cascade');
});
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
