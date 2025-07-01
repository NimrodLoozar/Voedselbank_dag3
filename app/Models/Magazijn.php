<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magazijn extends Model
{
    use HasFactory;

    protected $table = 'magazijnen';

    protected $fillable = [
        'ontvangstdatum',
        'uitleveringsdatum',
        'verpakkings_eenheid',
        'aantal'
    ];

    protected $casts = [
        'ontvangstdatum' => 'date',
        'uitleveringsdatum' => 'date'
    ];

    public function producten()
    {
        return $this->belongsToMany(Product::class, 'product_per_magazijn', 'magazijn_id', 'product_id')
            ->withPivot('locatie');
    }
}
