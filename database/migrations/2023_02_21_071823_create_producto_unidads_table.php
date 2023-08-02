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
        Schema::create('producto_unidads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('unidad_medida_id');
            $table->double('cantidad_unidades',6,2);
            $table->double('stock',12,2)->default(0);
            $table->string('estado')->default('1');
            $table->timestamps();

            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('unidad_medida_id')->references('id')->on('unidad_medidas');
            $table->unique(['producto_id','unidad_medida_id','cantidad_unidades']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_unidads');
    }
};
