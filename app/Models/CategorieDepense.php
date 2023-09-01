<?php

namespace App\Models;

use App\Models\GroupeCategorieDepense;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategorieDepense extends Model
{
    use HasFactory;

    protected $table = "categories_depenses";

    protected $fillable = [
        'nom',
        'statut',
        'groupe_categories_depenses_id'
    ];

    public function depenses()
    {
        return $this->hasMany(Depense::class);
    }

    public function groupe()
    {
        return $this->belongsTo(GroupeCategorieDepense::class, 'groupe_categories_depenses_id');
    }
}
