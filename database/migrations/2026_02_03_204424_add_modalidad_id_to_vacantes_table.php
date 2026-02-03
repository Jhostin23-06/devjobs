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
        Schema::table('vacantes', function (Blueprint $table) {
            $table->foreignId('modalidad_id')
                ->nullable()
                ->after('categoria_id') // Opcional: para ponerlo después de categoria_id
                ->constrained('modalidades')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vacantes', function (Blueprint $table) {
            $table->dropForeign(['modalidad_id']);
            $table->dropColumn('modalidad_id');
        });
    }
};
