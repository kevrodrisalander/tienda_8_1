<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_id');
            $table->integer('cantidad')->default(0);
            $table->string('ubicacion', 100)->nullable();
            $table->string('estado', 20)->default('disponible');
            $table->integer('minimo_seguro')->default(0);
            $table->integer('maximo_permitido')->nullable();
            $table->timestamp('fecha_ingreso')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->string('lote', 50)->nullable();
            $table->text('observaciones')->nullable();
            $table->boolean('activo')->default(true);
            $table->string('tipo_movimiento', 20)->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('id_lote')->nullable();

            // FKs
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('id_lote')->references('id_lote')->on('lotes_producto')->nullOnDelete();
            $table->foreign('usuario_id')->references('id')->on('usuarios')->nullOnDelete();
        });

        // Agregar CHECK constraints usando SQL directo
        DB::statement("ALTER TABLE stock ADD CONSTRAINT stock_estado_check CHECK (estado IN ('disponible','reservado','agotado','transito'))");
        DB::statement("ALTER TABLE stock ADD CONSTRAINT stock_tipo_movimiento_check CHECK (tipo_movimiento IN ('entrada','salida','ajuste','traslado'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('stock');
    }
};

