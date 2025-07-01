<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leverancier extends Model
{
    use HasFactory;

    protected $table = 'leveranciers';

    protected $fillable = [
        'naam',
        'contact_persoon',
        'leverancier_nummer',
        'leverancier_type'
    ];

    protected $casts = [
        'leverancier_type' => 'string'
    ];

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'contact_per_leverancier', 'leverancier_id', 'contact_id');
    }

    public function producten()
    {
        return $this->belongsToMany(Product::class, 'product_per_leverancier', 'leverancier_id', 'product_id')
            ->withPivot('datum_aangeleverd', 'datum_eerst_volgende_levering');
    }
}
