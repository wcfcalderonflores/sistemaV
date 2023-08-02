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
        Schema::create('producto_precio_clientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_unidad_id');
            $table->unsignedBigInteger('tipo_cliente_id');
            $table->double('precio_venta',8,2);
            $table->double('precio_compra',8,2)->nullable();
            $table->string('estado',1)->default('1');
            $table->timestamps();

            $table->foreign('producto_unidad_id')->references('id')->on('producto_unidads');
            $table->foreign('tipo_cliente_id')->references('id')->on('tipo_clientes');
            $table->unique(['producto_unidad_id','tipo_cliente_id'],'precio_tipo_cliente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_precio_clientes');
    }
};
