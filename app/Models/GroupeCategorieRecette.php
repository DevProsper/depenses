<?php

namespace App\Models;

use App\Models\CategorieRecette;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroupeCategorieRecette extends Model
{
    use HasFactory;

    protected $table = "groupe_categories_recettes";

    protected $fillable = [
        'nom',
        'statut'
    ];

    public function categorieRecette()
    {
        return $this->hasMany(CategorieRecette::class);
    }
}
