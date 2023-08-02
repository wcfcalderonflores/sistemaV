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
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proveedor_id');
            $table->unsignedBigInteger('comprobante_id');
            $table->string('numero_comprobante',20);
            $table->date('fecha_compra');
            $table->string('forma_pago',1); // 1=contado; 2= credito, 3= parcial
            $table->string('estado',1)->default('2'); //0= anulado , 1=terminado, 2=registrado
            $table->string('estado_igv',1)->default('0'); // 0= sin igv 1= con igv, 2= incluye igv
            $table->double('porcentaje_igv',4,2)->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('arqueo_id')->nullable();
            $table->timestamps();

            $table->unique('numero_comprobante');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('proveedor_id')->references('persona_id')->on('proveedors');
            $table->foreign('comprobante_id')->references('id')->on('comprobantes');
            $table->foreign('arqueo_id')->references('id')->on('arqueos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
