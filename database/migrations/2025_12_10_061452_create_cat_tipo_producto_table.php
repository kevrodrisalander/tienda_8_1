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
        Schema::create('cat_tipo_producto', function (Blueprint $table) {
            $table->id(); // equivalente a serial4 + primary key

            $table->string('nombre', 100);
            $table->string('descripcion', 100)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cat_tipo_producto');
    }
};
