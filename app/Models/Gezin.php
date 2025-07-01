<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gezin extends Model
{
    use HasFactory;

    protected $table = 'gezinnen';

    protected $fillable = [
        'naam',
        'code',
        'omschrijving',
        'aantal_volwassenen',
        'aantal_kinderen',
        'aantal_babys',
        'totaal_aantal_personen'
    ];

    public function personen()
    {
        return $this->hasMany(Persoon::class, 'gezin_id');
    }

    public function voedselpakketten()
    {
        return $this->hasMany(Voedselpakket::class, 'gezin_id');
    }

    public function eetwensen()
    {
        return $this->belongsToMany(Eetwens::class, 'eetwens_per_gezin', 'gezin_id', 'eetwens_id');
    }

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'contact_per_gezin', 'gezin_id', 'contact_id');
    }
}
