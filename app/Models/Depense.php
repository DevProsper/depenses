<?php

namespace App\Models;

use App\Models\CategorieDepense;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Depense extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'statut',
        'montant',
        'date_depense',
        'categories_depenses_id'
    ];

    public function categorieDepense()
    {
        return $this->belongsTo(CategorieDepense::class, 'categories_depenses_id');
    }
}
