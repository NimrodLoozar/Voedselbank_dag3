<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPerLeverancier extends Model
{
    protected $table = 'product_per_leverancier';
    protected $fillable = [
        'leverancier_id',
        'product_id',
        'houdbaarheidsdatum',
        'datum_aangeleverd',
        'datum_eerst_volgende_levering'
    ];

    public function leverancier()
    {
        return $this->belongsTo(Leverancier::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
