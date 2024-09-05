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
        Schema::create('user_ads', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('nip');
            $table->string('user');
            $table->string('lastip')->nullable();
            //$table->string('equipo_ip');
            $table->foreignId('equipos_ip')->constrained('equipos')->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_ads');
    }
};
