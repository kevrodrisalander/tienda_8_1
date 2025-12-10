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
        Schema::create('cat_categorias', function (Blueprint $table) {
            $table->id(); // equivalente a int4 + secuencia autoincremental

            $table->string('categoria', 50);

            // timestamp con valor por defecto CURRENT_TIMESTAMP
            $table->timestamp('fecha')->useCurrent();

            // si no quieres created_at / updated_at, NO pongas $table->timestamps()
        });
    }

    public function down()
    {
        Schema::dropIfExists('cat_categorias');
    }
};
