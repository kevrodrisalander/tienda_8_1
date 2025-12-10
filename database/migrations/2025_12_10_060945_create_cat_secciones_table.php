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
        Schema::create('cat_secciones', function (Blueprint $table) {
            $table->id(); // id auto-incremental, equivalente a int4 + primary key

            $table->string('nombre', 100);
            $table->string('descripcion', 100)->nullable();
            $table->string('slug')->nullable();

            $table->unique('id'); // según tu constraint UNIQUE
        });
    }

    public function down()
    {
        Schema::dropIfExists('cat_secciones');
    }
};
