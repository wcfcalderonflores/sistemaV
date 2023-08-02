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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',100)->unique();
            $table->string('marca',100)->nullable();
            $table->string('imagen',100)->nullable();
            $table->unsignedBigInteger('categoria_id');
            //$table->unsignedBigInteger('unidad_medida_id');
            //$table->double('precio',8,2);
            $table->double('stock',12,2)->nullable();
            $table->double('stock_minimo',8,2);
            $table->enum('afecto_igv',['G','E','I'])->default('G');
            $table->string('estado',1)->default('1');
            $table->timestamps();

            //$table->unique('nombre');
            $table->foreign('categoria_id')->references('id')->on('producto_categorias');

            //$table->foreign('unidad_medida_id')->references('id')->on('unidad_medidas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
