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
        Schema::create('cat_estatus_inventario', function (Blueprint $table) {
    $table->id();  // Esto configura el campo 'id' como auto-incremental
    $table->boolean('activo');
    $table->timestamps();
    $table->softDeletes(); // Si usas soft deletes
});
    }

    public function down()
    {
        Schema::dropIfExists('cat_estatus_inventario');
    }
};
