<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('solicitudes_reposicion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('cantidad_solicitada');
            $table->string('estado')->default('pendiente');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('solicitudes_reposicion');
    }
};
