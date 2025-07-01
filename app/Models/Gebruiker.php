<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Persoon;
use App\Models\Rol;

class Gebruiker extends Model
{
    use HasFactory;

    protected $table = 'gebruikers';

    protected $fillable = [
        'persoon_id',
        'inlog_naam',
        'gebruikersnaam',
        'wachtwoord',
        'is_ingelogd',
        'ingelogd',
        'uitgelogd'
    ];

    protected $casts = [
        'is_ingelogd' => 'boolean',
        'ingelogd' => 'datetime',
        'uitgelogd' => 'datetime'
    ];

    protected $hidden = [
        'wachtwoord'
    ];

    public function persoon()
    {
        return $this->belongsTo(Persoon::class, 'persoon_id');
    }

    public function rollen()
    {
        return $this->belongsToMany(Rol::class, 'rol_per_gebruiker', 'gebruiker_id', 'rol_id');
    }
}
