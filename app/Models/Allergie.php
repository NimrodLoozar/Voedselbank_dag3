<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allergie extends Model
{
    use HasFactory;

    protected $table = 'allergies';

    protected $fillable = [
        'naam',
        'omschrijving',
        'anafylactisch_risico'
    ];

    protected $casts = [
        'anafylactisch_risico' => 'string'
    ];

    public function personen()
    {
        return $this->belongsToMany(Persoon::class, 'allergie_per_persoon', 'allergie_id', 'persoon_id');
    }
}
