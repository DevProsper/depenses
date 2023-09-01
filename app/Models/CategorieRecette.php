<?php

namespace App\Models;

use App\Models\GroupeCategorieRecette;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategorieRecette extends Model
{
    use HasFactory;

    protected $table = "categories_recettes";

    protected $fillable = [
        'nom',
        'statut',
        'groupe_categories_recettes_id'
    ];

    public function recettes()
    {
        return $this->hasMany(Recette::class);
    }

    public function groupe()
    {
        return $this->belongsTo(GroupeCategorieRecette::class, 'groupe_categories_recettes_id');
    }
}
