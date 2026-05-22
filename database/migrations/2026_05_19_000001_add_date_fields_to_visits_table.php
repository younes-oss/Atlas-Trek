<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            // On insère les colonnes après max_places pour garder un ordre logique
            $table->dateTime('date_depart')->nullable()->after('max_places');
            $table->dateTime('date_fin')->nullable()->after('date_depart');
            $table->dateTime('date_limite_reservation')->nullable()->after('date_fin');
        });
    }

    public function down(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->dropColumn(['date_depart', 'date_fin', 'date_limite_reservation']);
        });
    }
};
