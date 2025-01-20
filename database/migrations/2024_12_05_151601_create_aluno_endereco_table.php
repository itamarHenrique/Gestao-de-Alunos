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
        Schema::create('aluno_endereco', function (Blueprint $table) {
            $table->primary(['aluno_id', 'endereco_id']);
            $table->unsignedBigInteger('aluno_id')->nullable();
            $table->unsignedBigInteger('endereco_id')->nullable();
            $table->timestamps();


            $table->foreign('aluno_id')->references('id')->on('alunos')->onDelete('cascade');
            $table->foreign('endereco_id')->references('id')->on('enderecos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aluno_endereco');
    }
};
