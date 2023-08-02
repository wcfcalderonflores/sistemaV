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
        Schema::create('detalle_ajuste_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ajuste_stock_id');
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('producto_unidad_id');
            $table->double('cantidad',8,2);
            $table->double('cantidad_unidad',8,2);
            $table->double('precio_compra',8,2);
            $table->double('cantidad_recuperada',8,2)->default(0);
            //$table->string('razon',100)->nullable();
            $table->timestamps();

            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('producto_unidad_id')->references('id')->on('producto_unidads');
            $table->foreign('ajuste_stock_id')->references('id')->on('ajuste_stocks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_ajuste_stocks');
    }
};
