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
        Schema::create('usuarios', function (Blueprint $table) {
    $table->id(); // serial4 NOT NULL
    $table->string('usuario', 50);
    $table->string('correo', 50)->unique();
    $table->string('clave', 350); // Tu columna original intacta
    $table->unsignedBigInteger('id_rol');

    // ✅ Mantenemos tu columna de fecha original:
    $table->timestamp('fecha')->useCurrent();

    $table->boolean('activo')->default(true);

    $table->foreign('id_rol')->references('id_rol')->on('cat_roles')->onDelete('restrict');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
