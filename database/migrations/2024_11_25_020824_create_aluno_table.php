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
        $userStatus = config('constants.user_status');

        Schema::create('alunos', function (Blueprint $table) use ($userStatus) {
            $table->id();
            $table->enum('user_status', $userStatus)->default('ativo');
            $table->string('primeiro_nome', 255);
            $table->string('sobrenome', 255);
            $table->string('matricula', 255)->unique;
            $table->string('email', 100)->unique();
            $table->string('celular', 20)->unique();
            $table->string('unidade_de_ensino', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alunos');
    }
};
