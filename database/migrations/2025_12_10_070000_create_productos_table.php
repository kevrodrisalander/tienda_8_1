<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id(); // id serial4
            $table->string('descripcion', 50);
            $table->integer('stock');
            $table->integer('precio_venta');
            $table->unsignedBigInteger('id_status');
            $table->unsignedBigInteger('id_categoria');
            $table->string('name_file', 350);
            $table->timestamp('fecha');
            $table->unsignedBigInteger('id_marca')->nullable();
            $table->unsignedBigInteger('id_observaciones')->nullable(); //  columna agregada 11/03/26
             $table->boolean('activo')->default(true); // columna agregada 11/03/26

            // FKs
            $table->foreign('id_status')->references('id')->on('cat_estatus_inventario')->onDelete('cascade');
            $table->foreign('id_categoria')->references('id')->on('cat_categorias')->onDelete('cascade');
            $table->foreign('id_marca')->references('id')->on('cat_marcas')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};

