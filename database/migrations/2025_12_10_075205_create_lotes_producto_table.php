<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lotes_producto', function (Blueprint $table) {
            $table->id('id_lote');
            $table->unsignedBigInteger('id')->nullable(); // referencia a productos
            $table->string('codigo_lote', 50);
            $table->date('fecha_ingreso');
            $table->date('fecha_caducidad')->nullable();
            $table->integer('cantidad');
            $table->text('observaciones')->nullable();

            // FK
            $table->foreign('id')->references('id')->on('productos')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lotes_producto');
    }
};
