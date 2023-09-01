<?php

namespace App\Models;

use App\Models\CategorieDepense;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recette extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'statut',
        'montant',
        'categories_recettes_id'
    ];

    public function categorieRecette()
    {
        return $this->belongsTo(CategorieRecette::class, 'categories_recettes_id');
    }

    public function depense()
    {
        return $this->hasMany(Depense::class);
    }
}
