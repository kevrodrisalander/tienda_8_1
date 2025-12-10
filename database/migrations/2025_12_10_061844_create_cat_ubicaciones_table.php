<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('cat_ubicaciones', function (Blueprint $table) {
        $table->id('id_ubicacion'); // equivalente a serial4 + primary key

        $table->string('clave_ubicacion', 10)->unique();
        $table->string('nombre_ubicacion', 100);
        $table->string('tipo_ubicacion', 50)->nullable();
        $table->string('direccion', 255)->nullable();
        $table->string('ciudad', 100)->nullable();
        $table->string('estado', 100)->nullable();
        $table->string('codigo_postal', 10)->nullable();
        $table->string('telefono', 20)->nullable();
        $table->integer('capacidad_m2')->nullable();
        $table->boolean('estatus')->default(true)->nullable();
    });
}

public function down()
{
    Schema::dropIfExists('cat_ubicaciones');
}

};
