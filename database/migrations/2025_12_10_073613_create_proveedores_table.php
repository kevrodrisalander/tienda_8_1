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
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id(); // serial4 NOT NULL
            $table->string('nombre', 255);
            $table->string('contacto', 100)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->text('direccion')->nullable();
            $table->timestamp('fecha_registro')->useCurrent()->nullable();
            $table->unsignedBigInteger('id_cat_marcas')->nullable(); // referencia a cat_marcas

            // Foreign key opcional
            $table->foreign('id_cat_marcas')->references('id')->on('cat_marcas')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
