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
        Schema::create('venta_detalle_compras', function (Blueprint $table) {
            $table->unsignedBigInteger('venta_detalle_id');
            $table->unsignedBigInteger('compra_detalle_id');
            $table->double('cantidad',8,2);
            $table->double('precio_compra',8,2);
            $table->timestamps();

            $table->primary(['venta_detalle_id','compra_detalle_id']);
            $table->foreign('venta_detalle_id')->references('id')->on('venta_detalles')->onDelete('cascade');
            $table->foreign('compra_detalle_id')->references('id')->on('compra_detalles');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta_detalle_compras');
    }
};
