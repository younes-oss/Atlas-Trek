<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->enum('status', ['en_attente', 'confirmé', 'annulé', 'expiré'])
                  ->default('en_attente')
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->enum('status', ['en_attente', 'confirmé', 'annulé'])
                  ->default('en_attente')
                  ->change();
        });
    }
};
