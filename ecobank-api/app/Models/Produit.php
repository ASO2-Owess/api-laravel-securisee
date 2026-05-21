<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produit extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom' ,
        'description' ,
        'type' ,
        'taux_interet' ,
        'duree_mois' ,
        'montant_min' ,
        'actif' ,
    ];

    protected $casts = [
        'actif'        => 'boolean' ,
        'taux_interet' => 'decimal:2' ,
        'montant_min'   => 'decimal:2' ,
    ];
}
