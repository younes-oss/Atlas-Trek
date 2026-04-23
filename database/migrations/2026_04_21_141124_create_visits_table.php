<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Cette méthode crée la table "visits" en base de données.
     */
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {

            $table->id();

            $table->string('title');

            $table->text('description');

            $table->string('location');

            $table->decimal('price', 8, 2);

            $table->integer('duration');

            // Niveau de difficulté : seulement ces 3 valeurs sont acceptées
            $table->enum('difficulty', ['facile', 'moyen', 'difficile']);

            // Clé étrangère : le guide (utilisateur) qui a créé cette visite
            // Si le guide est supprimé, ses visites sont aussi supprimées (cascade)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // created_at et updated_at (gérés automatiquement par Laravel)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * Cette méthode supprime la table (utile pour rollback).
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
