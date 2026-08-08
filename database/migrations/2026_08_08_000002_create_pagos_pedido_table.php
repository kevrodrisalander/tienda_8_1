<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos_pedido', function (Blueprint $table) {
            $table->id('id_pago');
            $table->unsignedBigInteger('id_pedido')->unique();
            $table->string('metodo', 20);
            $table->decimal('monto', 10, 2);

            // Campos exclusivos de efectivo.
            $table->decimal('monto_recibido', 10, 2)->nullable();
            $table->decimal('cambio', 10, 2)->nullable();

            // Campos operativos de tarjeta. Nunca guardar PAN completo, CVV o NIP.
            $table->string('tipo_tarjeta', 10)->nullable();
            $table->string('marca_tarjeta', 20)->nullable();
            $table->char('ultimos_cuatro', 4)->nullable();

            // Campos exclusivos de vales y referencia común de autorización.
            $table->string('emisor_vale', 50)->nullable();
            $table->string('referencia', 100)->nullable();
            $table->timestamp('fecha_pago');
            $table->timestamps();

            $table->foreign('id_pedido')
                ->references('id_pedido')
                ->on('pedidos')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos_pedido');
    }
};
