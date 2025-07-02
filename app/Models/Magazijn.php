<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Magazijn Model - beheert de voorraad in het magazijn
 * 
 * Deze class houdt bij wanneer spullen binnenkomen en uitgaan,
 * hoeveel er is en hoe het verpakt is.
 */
class Magazijn extends Model
{
    use HasFactory;

    // Vertel Laravel welke tabel dit model gebruikt
    protected $table = 'magazijnen';

    // Deze velden mogen gevuld worden via mass assignment
    protected $fillable = [
        'ontvangstdatum',      // Wanneer kregen we de spullen binnen?
        'uitleveringsdatum',   // Wanneer gaan ze weg?
        'verpakkings_eenheid', // Hoe zijn ze verpakt? (doos, zak, etc.)
        'aantal'               // Hoeveel hebben we er?
    ];

    // Zorg dat datums automatisch als Date objecten behandeld worden
    protected $casts = [
        'ontvangstdatum' => 'date',
        'uitleveringsdatum' => 'date'
    ];

    /**
     * Relatie met producten - een magazijn kan meerdere producten hebben
     * Via een tussentabel die ook de locatie bijhoudt waar het ligt
     */
    public function producten()
    {
        return $this->belongsToMany(Product::class, 'product_per_magazijn', 'magazijn_id', 'product_id')
            ->withPivot('locatie'); // Extra info: waar ligt het precies?
    }

    /**
     * Scope voor het ophalen van magazijnen met product informatie via joins
     */
    public function scopeWithProductInfo($query)
    {
        return $query->select([
            'magazijnen.*',
            'producten.naam as product_naam',
            'producten.status as product_status',
            'categories.naam as categorie_naam',
            'product_per_magazijn.locatie'
        ])
            ->leftJoin('product_per_magazijn', 'magazijnen.id', '=', 'product_per_magazijn.magazijn_id')
            ->leftJoin('producten', 'product_per_magazijn.product_id', '=', 'producten.id')
            ->leftJoin('categories', 'producten.categorie_id', '=', 'categories.id');
    }

    /**
     * Scope voor het filteren op voorraad status
     */
    public function scopeInStock($query)
    {
        return $query->where('aantal', '>', 0)
            ->whereNull('uitleveringsdatum');
    }

    /**
     * Scope voor het filteren op uitgeleverde items
     */
    public function scopeDelivered($query)
    {
        return $query->whereNotNull('uitleveringsdatum');
    }

    /**
     * Accessor voor het berekenen van dagen in voorraad
     */
    public function getDagenInVoorraadAttribute()
    {
        if ($this->uitleveringsdatum) {
            return $this->ontvangstdatum->diffInDays($this->uitleveringsdatum);
        }

        return $this->ontvangstdatum->diffInDays(now());
    }

    /**
     * Check of dit magazijn item bijna vol is (meer dan 80% van capaciteit)
     */
    public function isBijnaVol($maxCapaciteit = 100)
    {
        return ($this->aantal / $maxCapaciteit) >= 0.8;
    }

    /**
     * Statische method voor het ophalen van voorraad statistieken via stored procedure
     */
    public static function getStatistics()
    {
        try {
            return DB::select('CALL GetMagazijnStatistics()')[0] ?? null;
        } catch (\Exception $e) {
            Log::error('Fout bij ophalen magazijn statistieken: ' . $e->getMessage());
            return null;
        }
    }
}
