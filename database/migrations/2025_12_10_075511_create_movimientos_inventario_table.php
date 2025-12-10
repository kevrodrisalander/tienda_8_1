<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos_inventario', function (Blueprint $table) {
            $table->id('id_movimiento');
            $table->unsignedBigInteger('id_producto');
            $table->string('tipo_movimiento', 20);
            $table->integer('cantidad');
            $table->timestamp('fecha')->useCurrent();
            $table->string('referencia', 100)->nullable();
            $table->text('observaciones')->nullable();

            // Foreign key hacia productos
            $table->foreign('id_producto')
                ->references('id')
                ->on('productos')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos_inventario');
    }
};
