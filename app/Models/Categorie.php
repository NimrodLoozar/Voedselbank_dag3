<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'naam',
        'omschrijving'
    ];

    public function producten()
    {
        return $this->hasMany(Product::class, 'categorie_id');
    }
}
