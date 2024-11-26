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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matricula_id')->constrained('matriculas')->onDelete('cascade');
            $table->string('metodo_pago');
            $table->string('comprobante_pago')->nullable();
            $table->decimal('monto', 10, 2);
            $table->date('fecha_pago');
            $table->boolean('totalmente_pagado')->default(false);
            $table->decimal('valor_pendiente', 10, 2)->nullable();
            $table->date('fecha_proximo_pago')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};