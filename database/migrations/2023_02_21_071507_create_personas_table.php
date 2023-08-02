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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->enum('tipo_documento',['01','04','06','07']); // 01=dni;04=carnet ext; 06=ruc; 07=pasaporte
            $table->string('numero_documento',20)->unique();
            $table->enum('sexo',['M','F']);
            $table->string('direccion')->nullable();
            $table->string('celular',12)->nullable();
            $table->string('correo')->unique()->nullable();
            $table->string('ubigeo_id')->nullable();

            $table->foreign('ubigeo_id')->references('id')->on('ubigeos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
