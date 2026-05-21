<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    // INDEX — Lister tous les produits
    public function index()
    {
        $produits = Produit::query()
            ->where('actif', '=', true)
            ->get();

        return response()->json([
            'message'  => 'Liste des produits',
            'produits' => $produits,
            'total'    => $produits->count(),
        ]);
    }

    // SHOW — Voir un produit
    public function show($id)
    {
        $produit = Produit::query()->find($id);

        if (!$produit) {
            return response()->json([
                'message' => 'Produit introuvable',
            ], 404);
        }

        return response()->json($produit);
    }

    // STORE — Créer un produit (admin seulement)
    public function store(Request $request)
    {
        $data = $request->validate([
            'nom'          => 'required|string|max:255',
            'description'  => 'nullable|string',
            'type'         => 'required|in:credit,epargne,placement',
            'taux_interet' => 'required|numeric|min:0|max:100',
            'duree_mois'   => 'required|integer|min:1',
            'montant_min'  => 'required|numeric|min:0',
        ]);

        $produit = Produit::create($data);

        return response()->json([
            'message' => 'Produit créé avec succès',
            'produit' => $produit,
        ], 201);
    }

    // UPDATE — Modifier un produit (admin seulement)
    public function update(Request $request, $id)
    {
        $produit = Produit::query()->find($id);

        if (!$produit) {
            return response()->json([
                'message' => 'Produit introuvable',
            ], 404);
        }

        $data = $request->validate([
            'nom'          => 'sometimes|string|max:255',
            'description'  => 'nullable|string',
            'type'         => 'sometimes|in:credit,epargne,placement',
            'taux_interet' => 'sometimes|numeric|min:0|max:100',
            'duree_mois'   => 'sometimes|integer|min:1',
            'montant_min'  => 'sometimes|numeric|min:0',
        ]);

        $produit->update($data);

        return response()->json([
            'message' => 'Produit modifié avec succès',
            'produit' => $produit,
        ]);
    }

    // DESTROY — Supprimer un produit (admin seulement)
    public function destroy($id)
    {
        $produit = Produit::query()->find($id);

        if (!$produit) {
            return response()->json([
                'message' => 'Produit introuvable',
            ], 404);
        }

        $produit->delete();

        return response()->json([
            'message' => 'Produit supprimé avec succès',
        ]);
    }
}
