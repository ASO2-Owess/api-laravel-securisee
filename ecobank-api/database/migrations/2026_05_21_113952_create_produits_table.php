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
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->String('nom');
            $table->text('description')->nullable();
            $table->enum('type', ['credit', 'epargne', 'placement']);
            $table->decimal('taux_interet', 5, 2)->default(0);
            $table->integer('duree_mois')->default(12);
            $table->decimal('montant_min', 15, 2)->default(0);
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
