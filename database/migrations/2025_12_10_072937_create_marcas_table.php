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
        Schema::create('marcas', function (Blueprint $table) {
            $table->id('id_marca'); // serial4 NOT NULL
            $table->string('nombre_marca', 100);
            $table->text('descripcion')->nullable();
            $table->string('pais_origen', 50)->nullable();
            $table->string('sitio_web', 255)->nullable();
            $table->boolean('estatus')->default(true); // Sin nullable(), valor predeterminado de true
            $table->timestamp('fecha_registro')->useCurrent(); // Eliminado nullable()
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marcas');
    }
};
