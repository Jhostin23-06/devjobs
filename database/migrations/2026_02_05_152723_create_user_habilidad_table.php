<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_habilidad', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('habilidad_id')
                    ->constrained('habilidades')  // <-- Especificar tabla aquí
                    ->onDelete('cascade');
            $table->integer('nivel')->default(1); // 1-5 o 1-10
            $table->integer('experiencia_meses')->nullable();
            $table->timestamps();

            // Para evitar duplicados
            $table->unique(['user_id', 'habilidad_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_habilidad');
    }
};
