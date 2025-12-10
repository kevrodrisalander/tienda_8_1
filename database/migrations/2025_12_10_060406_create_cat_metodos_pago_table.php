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
    Schema::create('cat_metodos_pago', function (Blueprint $table) {
        $table->id('id_metodo'); // equivalente a int4 + secuencia + primary key

        $table->string('nombre', 50)->unique();
        $table->text('descripcion')->nullable();
    });
}

public function down()
{
    Schema::dropIfExists('cat_metodos_pago');
}

};
