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
    $table->id();
    $table->boolean('activo');
    $table->string('tipo'); // Asegúrate que tu seeder tenga 'tipo'
    $table->timestamps();       // crea created_at y updated_at
    $table->softDeletes();      // crea deleted_at
    $table->timestamp('modified_at')->nullable(); // nueva columna
});
    }

    public function down()
    {
        Schema::dropIfExists('cat_estatus_inventario');
    }
};
