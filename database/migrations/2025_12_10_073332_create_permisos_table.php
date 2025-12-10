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
        Schema::create('productos', function (Blueprint $table) {
            $table->id(); // serial4 NOT NULL
            $table->string('descripcion', 50);
            $table->integer('stock');
            $table->integer('precio_venta');
            $table->unsignedBigInteger('id_status'); // referencia a cat_estatus_inventario
            $table->unsignedBigInteger('id_categoria'); // referencia a cat_categorias
            $table->string('name_file', 350);
            $table->timestamp('fecha');
            $table->unsignedBigInteger('id_marca')->nullable(); // referencia a cat_marcas

            // Foreign keys (si quieres mantener integridad referencial)
            $table->foreign('id_status')->references('id')->on('cat_estatus_inventario')->onDelete('restrict');
            $table->foreign('id_categoria')->references('id')->on('cat_categorias')->onDelete('restrict');
            $table->foreign('id_marca')->references('id')->on('cat_marcas')->onDelete('set null');
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
