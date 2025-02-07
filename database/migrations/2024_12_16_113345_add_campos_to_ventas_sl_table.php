<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ventas_sl', function (Blueprint $table) {
            $table->string('tipo_movimiento')->nullable();
            $table->text('notasmodelo347')->nullable();
            $table->text('correo')->nullable(); // Se pueden almacenar varios correos separados por comas.
            $table->string('agente')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ventas_sl', function (Blueprint $table) {
            $table->dropColumn(['tipo_movimiento', 'notasmodelo347', 'correo', 'agente']);
        });
    }
};
