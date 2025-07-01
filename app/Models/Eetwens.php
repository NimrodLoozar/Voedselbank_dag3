<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eetwens extends Model
{
    use HasFactory;

    protected $table = 'eetwensen';

    protected $fillable = [
        'naam',
        'omschrijving'
    ];

    public function gezinnen()
    {
        return $this->belongsToMany(Gezin::class, 'eetwens_per_gezin', 'eetwens_id', 'gezin_id');
    }
}
