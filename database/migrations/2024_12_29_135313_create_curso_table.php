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
        $userFormacao = config('constants.user_formacao');

        Schema::create('cursos', function (Blueprint $table) use ($userFormacao) {
            $table->id();
            $table->string('nome', 255)->unique();
            $table->enum('tipo_formacao', $userFormacao);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curso');
    }
};
