<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'producten';

    protected $fillable = [
        'categorie_id',
        'naam',
        'soort_allergie',
        'barcode',
        'houdbaarheidsdatum',
        'omschrijving',
        'status'
    ];

    protected $casts = [
        'houdbaarheidsdatum' => 'date',
        'status' => 'string'
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    public function leveranciers()
    {
        return $this->belongsToMany(Leverancier::class, 'product_per_leverancier', 'product_id', 'leverancier_id')
            ->withPivot('datum_aangeleverd', 'datum_eerst_volgende_levering');
    }

    public function magazijnen()
    {
        return $this->belongsToMany(Magazijn::class, 'product_per_magazijn', 'product_id', 'magazijn_id')
            ->withPivot('locatie');
    }

    public function voedselpakketten()
    {
        return $this->belongsToMany(Voedselpakket::class, 'product_per_voedselpakket', 'product_id', 'voedselpakket_id')
            ->withPivot('aantal_product_eenheden');
    }
}
