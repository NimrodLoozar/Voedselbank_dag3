<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts';

    protected $fillable = [
        'straat',
        'huisnummer',
        'toevoeging',
        'postcode',
        'woonplaats',
        'email',
        'mobiel'
    ];

    public function leveranciers()
    {
        return $this->belongsToMany(Leverancier::class, 'contact_per_leverancier', 'contact_id', 'leverancier_id');
    }

    public function gezinnen()
    {
        return $this->belongsToMany(Gezin::class, 'contact_per_gezin', 'contact_id', 'gezin_id');
    }
}
