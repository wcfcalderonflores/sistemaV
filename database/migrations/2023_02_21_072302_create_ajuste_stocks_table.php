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
        Schema::create('ajuste_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->string('tipo_ajuste',1); //1=vencimiento; 2=perdida; 3=otro
            $table->string('referencia',100);
            $table->string('estado',1)->default('2'); //0= anulado , 1=terminado, 2=registrado
            $table->unsignedBigInteger('arqueo_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('arqueo_id')->references('id')->on('arqueos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ajuste_stocks');
    }
};
