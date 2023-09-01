<?php

namespace App\Models;

use App\Models\CategorieDepense;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroupeCategorieDepense extends Model
{
    use HasFactory;

    protected $table = "groupe_categories_depenses";

    protected $fillable = [
        'nom',
        'statut'
    ];

    public function categorieDepense()
    {
        return $this->hasMany(CategorieDepense::class);
    }
}
