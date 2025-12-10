<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id('id_venta');
            $table->timestamp('fecha')->useCurrent();
            $table->decimal('total', 10, 2);
            $table->unsignedBigInteger('id_cliente');
            $table->string('metodo_pago', 50);
            $table->unsignedBigInteger('id_estatus')->nullable();

            // FK hacia clientes
            $table->foreign('id_cliente')
                ->references('id_cliente')
                ->on('clientes')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
