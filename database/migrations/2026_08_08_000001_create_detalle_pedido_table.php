<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_pedido', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pedido');
            $table->unsignedBigInteger('id_producto');
            $table->string('nombre_producto', 255);
            $table->unsignedInteger('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->timestamps();

            $table->foreign('id_pedido')->references('id_pedido')->on('pedidos')->cascadeOnDelete();
            $table->foreign('id_producto')->references('id')->on('productos')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_pedido');
    }
};
