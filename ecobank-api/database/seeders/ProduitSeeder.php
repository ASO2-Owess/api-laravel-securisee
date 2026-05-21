<?php

namespace Database\Seeders;

use App\Models\Produit;
use Illuminate\Database\Seeder;

class ProduitSeeder extends Seeder
{
    public function run(): void
    {
        Produit::updateOrCreate(
            ['nom' => 'Credit Auto Ecobank'],
            [
                'description'  => 'Financement vehicule neuf ou occasion',
                'type'         => 'credit',
                'taux_interet' => 8.50,
                'duree_mois'   => 60,
                'montant_min'  => 2000000,
                'actif'        => true,
            ]
        );

        Produit::updateOrCreate(
            ['nom' => 'Epargne Plus'],
            [
                'description'  => 'Compte epargne remunere',
                'type'         => 'epargne',
                'taux_interet' => 4.25,
                'duree_mois'   => 12,
                'montant_min'  => 50000,
                'actif'        => true,
            ]
        );

        Produit::updateOrCreate(
            ['nom' => 'Placement Immobilier'],
            [
                'description'  => 'Placement a terme pour projet immobilier',
                'type'         => 'placement',
                'taux_interet' => 6.00,
                'duree_mois'   => 24,
                'montant_min'  => 5000000,
                'actif'        => true,
            ]
        );
    }
}
