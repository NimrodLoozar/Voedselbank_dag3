<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voedselpakket extends Model
{
    use HasFactory;

    protected $table = 'voedselpakketten';

    protected $fillable = [
        'gezin_id',
        'pakket_nummer',
        'datum_samenstelling',
        'datum_uitgifte',
        'status'
    ];

    protected $casts = [
        'datum_samenstelling' => 'date',
        'datum_uitgifte' => 'date',
        'status' => 'string'
    ];

    public function gezin()
    {
        return $this->belongsTo(Gezin::class, 'gezin_id');
    }

    public function producten()
    {
        return $this->belongsToMany(Product::class, 'product_per_voedselpakket', 'voedselpakket_id', 'product_id')
            ->withPivot('aantal_product_eenheden');
    }
}
