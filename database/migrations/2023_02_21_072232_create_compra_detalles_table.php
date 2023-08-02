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
        Schema::create('compra_detalles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('compra_id');
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('producto_unidad_id');
            $table->double('precio',8,2);
            $table->double('precio_compra',8,2);
            $table->double('cantidad',8,2);
            $table->double('stock_unidades',8,2);
            $table->double('stock',8,2); // HABILITAR CUNADO SE TRABAJE CON STOCK POR PRODUCTO UNIDAD
            $table->double('cantidad_unidad',8,2);
            $table->date('fecha_vencimiento')->nullable();
            $table->double('descuento')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            
            $table->foreign('compra_id')->references('id')->on('compras')->onDelete('cascade');
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
        Schema::dropIfExists('compra_detalles');
    }
};
