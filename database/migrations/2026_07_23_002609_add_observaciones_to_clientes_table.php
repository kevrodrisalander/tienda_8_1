<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('clientes', 'observaciones')) {
            return;
        }

        Schema::table('clientes', function (Blueprint $table) {
            $table->string('observaciones', 100)->nullable();
        });
    }

    public function down(): void
    {
        if (!Schema::hasColumn('clientes', 'observaciones')) {
            return;
        }

        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn('observaciones');
        });
    }
};
