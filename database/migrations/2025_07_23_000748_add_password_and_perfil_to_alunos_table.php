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
        $perfil = config('constants.perfil_aluno');

        Schema::table('alunos', function (Blueprint $table) use ($perfil) {

        $table->enum('perfil', $perfil)->default('usuario');
        $table->string('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alunos', function (Blueprint $table) {
            //
        });
    }
};
