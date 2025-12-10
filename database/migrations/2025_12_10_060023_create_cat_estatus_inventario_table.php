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
            $table->id(); // id con auto-incremento

            $table->string('tipo')->nullable();
            $table->boolean('activo')->nullable();

            $table->timestamp('created_at')->nullable();
            $table->timestamp('modified_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cat_estatus_inventario');
    }
};
