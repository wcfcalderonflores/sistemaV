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
        Schema::create('arqueos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('caja_id');
            $table->unsignedBigInteger('usuario_id');
            $table->dateTime('fecha_apertura');
            $table->dateTime('fecha_cierre')->nullable();
            $table->double('monto_apertura',8,2);
            $table->double('monto_cierre',8,2)->nullable();
            $table->double('total_ventas',8,2)->nullable();
            $table->char('estado')->default('1');
            $table->char('estado_recibido')->default('1');
            $table->unsignedBigInteger('usuario_recibio')->nullable();
            $table->timestamps();

            $table->foreign('caja_id')->references('id')->on('cajas');
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->foreign('usuario_recibio')->references('id')->on('users');

            $table->index('fecha_apertura');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arqueos');
    }
};
