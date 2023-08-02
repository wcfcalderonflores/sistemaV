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
        Schema::create('venta_detalles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venta_id');
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('producto_unidad_id');
            $table->double('precio_registro',8,2);
            $table->double('precio',8,2);
            $table->double('precio_compra',8,2);
            $table->double('cantidad',8,2);
            $table->double('cantidad_unidad',8,2);
            $table->double('descuento',8,2)->nullable();
            $table->double('valor_igv',4,2)->default(0);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('venta_id')->references('id')->on('ventas')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('producto_unidad_id')->references('id')->on('producto_unidads');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta_detalles');
    }
};
