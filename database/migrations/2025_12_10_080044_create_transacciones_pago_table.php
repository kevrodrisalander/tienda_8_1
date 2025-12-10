<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transacciones_pago', function (Blueprint $table) {
            $table->id('id_transaccion');
            $table->unsignedBigInteger('id_venta');
            $table->unsignedBigInteger('id_metodo');
            $table->decimal('monto', 10, 2);
            $table->string('referencia_pago', 100)->nullable();
            $table->timestamp('fecha_pago')->useCurrent()->nullable();

            // FKs
            $table->foreign('id_venta')
                ->references('id_venta')
                ->on('ventas')
                ->onDelete('cascade');

            $table->foreign('id_metodo')
                ->references('id_metodo')
                ->on('cat_metodos_pago')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transacciones_pago');
    }
};
