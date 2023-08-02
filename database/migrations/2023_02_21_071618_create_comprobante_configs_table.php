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
        Schema::create('comprobante_configs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comprobante_id');
            $table->string('serie',20)->unique();
            $table->bigInteger('contador');
            $table->bigInteger('numero_maximo');
            $table->char('estado')->default('1');
            $table->double('valor_igv',4,2)->default(0);
            $table->timestamps();
            $table->foreign('comprobante_id')->references('id')->on('comprobantes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comprobante_configs');
    }
};
