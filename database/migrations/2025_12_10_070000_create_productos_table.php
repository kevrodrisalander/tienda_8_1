<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id(); // id serial4 nativo de Postgres
            $table->string('descripcion', 50);
            $table->integer('stock')->default(0); // Inicializado en 0 por seguridad

            $table->decimal('precio_venta', 10, 2);

            $table->unsignedBigInteger('id_status');
            $table->unsignedBigInteger('id_categoria');
            $table->string('name_file', 350)->nullable(); // nullable por si un producto se crea sin foto inicial
            $table->timestamp('fecha')->useCurrent(); // useCurrent evita que falle si no mandas la fecha en el Request
            $table->unsignedBigInteger('id_marca')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps(); // Agrega created_at y updated_at automáticamente, ideal para Laravel


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
