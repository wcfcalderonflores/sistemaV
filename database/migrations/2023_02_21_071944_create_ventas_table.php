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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('tipo_cliente_id');
            $table->bigInteger('numero_comprobante')->nullable();
            $table->unsignedBigInteger('arqueo_id')->nullable();
            $table->unsignedBigInteger('comprobante_config_id');
            $table->unsignedBigInteger('user_id');
            $table->dateTime('fecha');
            $table->double('valor_igv',4,2)->default(0);
            $table->char('estado')->default('2');
            $table->timestamps();

            $table->foreign('cliente_id')->references('persona_id')->on('clientes');
            $table->foreign('tipo_cliente_id')->references('id')->on('tipo_clientes');
            $table->foreign('arqueo_id')->references('id')->on('arqueos');
            $table->foreign('comprobante_config_id')->references('id')->on('comprobante_configs');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unique(['comprobante_config_id','numero_comprobante']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
