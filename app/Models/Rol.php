<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'rollen';

    protected $fillable = [
        'naam'
    ];

    public function gebruikers()
    {
        return $this->belongsToMany(Gebruiker::class, 'rol_per_gebruiker', 'rol_id', 'gebruiker_id');
    }
}
