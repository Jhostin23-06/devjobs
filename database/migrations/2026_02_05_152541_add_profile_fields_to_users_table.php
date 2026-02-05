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
        Schema::table('users', function (Blueprint $table) {
            // Información personal
            $table->string('telefono')->nullable()->after('email');
            $table->string('direccion')->nullable()->after('telefono');
            $table->string('ciudad')->nullable()->after('direccion');
            $table->string('pais')->nullable()->after('ciudad');
            $table->text('biografia')->nullable()->after('pais');
            $table->string('titulo_profesional')->nullable()->after('biografia');

            // Redes sociales
            $table->string('linkedin')->nullable()->after('titulo_profesional');
            $table->string('github')->nullable()->after('linkedin');
            $table->string('twitter')->nullable()->after('github');
            $table->string('website')->nullable()->after('twitter');

            // Foto de perfil
            $table->string('foto_perfil')->nullable()->after('website');
            
            // Configuración
            $table->boolean('perfil_publico')->default(true)->after('foto_perfil');
            $table->boolean('recibir_notificaciones')->default(true)->after('perfil_publico');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'telefono', 'direccion', 'ciudad', 'pais', 
                'biografia', 'titulo_profesional', 'linkedin', 
                'github', 'twitter', 'website', 'foto_perfil',
                'perfil_publico', 'recibir_notificaciones'
            ]);
        });
    }
};
