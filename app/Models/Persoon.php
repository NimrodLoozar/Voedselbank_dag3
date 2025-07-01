<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persoon extends Model
{
    use HasFactory;

    protected $table = 'personen';

    protected $fillable = [
        'gezin_id',
        'voornaam',
        'tussenvoegsel',
        'achternaam',
        'geboortedatum',
        'type_persoon',
        'is_vertegenwoordiger'
    ];

    protected $casts = [
        'geboortedatum' => 'date',
        'is_vertegenwoordiger' => 'boolean',
        'type_persoon' => 'string'
    ];

    public function gezin()
    {
        return $this->belongsTo(Gezin::class, 'gezin_id');
    }

    public function gebruiker()
    {
        return $this->hasOne(Gebruiker::class, 'persoon_id');
    }

    public function allergies()
    {
        return $this->belongsToMany(Allergie::class, 'allergie_per_persoon', 'persoon_id', 'allergie_id');
    }

    public function getVolledigeNaamAttribute()
    {
        return trim($this->voornaam . ' ' . $this->tussenvoegsel . ' ' . $this->achternaam);
    }
}
