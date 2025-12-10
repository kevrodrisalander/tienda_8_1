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
        Schema::create('cat_marcas', function (Blueprint $table) {
            $table->id(); // serial4 + primary key

            $table->string('nombre', 255);
            $table->string('descripcion', 20)->nullable();
            $table->string('tipo', 100)->nullable();

            // clave foránea corregida
            $table->unsignedBigInteger('provedor_id')->nullable();
            $table->foreign('provedor_id')
                ->references('id')
                ->on('cat_provedores') // CORREGIDO
                ->onDelete('set null');

            $table->timestamp('fecha_registro')->useCurrent()->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cat_marcas');
    }
};
