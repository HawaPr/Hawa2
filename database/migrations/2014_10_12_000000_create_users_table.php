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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Colonne ID en premier, auto-incrémentée
            $table->string('name'); // Nom de l'utilisateur
            $table->string('email')->unique(); // Email unique
            $table->timestamp('email_verified_at')->nullable(); // Date de vérification de l'email, peut être NULL
            $table->string('password'); // Mot de passe de l'utilisateur
            $table->enum('type_users', ['Admin', 'SoinsMedicaux', 'VolontaireSecouriste', 'Victime']); // Type d'utilisateur
            $table->decimal('latitude', 10, 7)->nullable(); // Latitude, peut être NULL
            $table->decimal('longitude', 10, 7)->nullable(); // Longitude, peut être NULL
            $table->rememberToken(); // Token de session pour "se souvenir" de l'utilisateur
            $table->timestamps(); // Colonne de timestamps pour created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users'); // Suppression de la table si la migration est annulée
    }
};
