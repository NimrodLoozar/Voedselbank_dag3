<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Product extends Model
{
    use HasFactory;

    protected $table = 'producten';

    protected $fillable = [
        'categorie_id',
        'naam',
        'soort_allergie',
        'barcode',
        'houdbaarheidsdatum',
        'omschrijving',
        'status'
    ];

    protected $casts = [
        'houdbaarheidsdatum' => 'date',
        'status' => 'string'
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    public function leveranciers()
    {
        return $this->belongsToMany(Leverancier::class, 'product_per_leverancier', 'product_id', 'leverancier_id')
            ->withPivot('datum_aangeleverd', 'datum_eerst_volgende_levering');
    }

    public function magazijnen()
    {
        return $this->belongsToMany(Magazijn::class, 'product_per_magazijn', 'product_id', 'magazijn_id')
            ->withPivot('locatie');
    }

    public function voedselpakketten()
    {
        return $this->belongsToMany(Voedselpakket::class, 'product_per_voedselpakket', 'product_id', 'voedselpakket_id')
            ->withPivot('aantal_product_eenheden');
    }

    /**
     * Scope voor het ophalen van producten met alle gerelateerde informatie via joins
     */
    public function scopeWithFullInfo($query)
    {
        return $query->select([
            'producten.*',
            'categories.naam as categorie_naam',
            DB::raw('SUM(magazijnen.aantal) as totaal_voorraad'),
            DB::raw('COUNT(DISTINCT product_per_leverancier.leverancier_id) as aantal_leveranciers'),
            DB::raw('COUNT(DISTINCT product_per_magazijn.magazijn_id) as aantal_magazijnen')
        ])
            ->leftJoin('categories', 'producten.categorie_id', '=', 'categories.id')
            ->leftJoin('product_per_magazijn', 'producten.id', '=', 'product_per_magazijn.product_id')
            ->leftJoin('magazijnen', 'product_per_magazijn.magazijn_id', '=', 'magazijnen.id')
            ->leftJoin('product_per_leverancier', 'producten.id', '=', 'product_per_leverancier.product_id')
            ->groupBy('producten.id', 'categories.naam');
    }

    /**
     * Scope voor producten op voorraad
     */
    public function scopeInStock($query)
    {
        return $query->whereHas('magazijnen', function ($q) {
            $q->where('aantal', '>', 0)
                ->whereNull('uitleveringsdatum');
        });
    }

    /**
     * Scope voor producten die bijna verlopen zijn
     */
    public function scopeExpiringSoon($query, $days = 7)
    {
        return $query->whereBetween('houdbaarheidsdatum', [
            now()->toDateString(),
            now()->addDays($days)->toDateString()
        ]);
    }

    /**
     * Scope voor producten van een specifieke categorie
     */
    public function scopeByCategory($query, $categorieId)
    {
        return $query->where('categorie_id', $categorieId);
    }

    /**
     * Check of dit product bijna verloopt
     */
    public function isExpiringSoon($days = 7)
    {
        return $this->houdbaarheidsdatum <= now()->addDays($days);
    }

    /**
     * Bereken totale voorraad van dit product
     */
    public function getTotalStock()
    {
        return $this->magazijnen()
            ->whereNull('uitleveringsdatum')
            ->sum('magazijnen.aantal');
    }

    /**
     * Haal verlopende producten op via stored procedure
     */
    public static function getExpiringProducts($days = 7)
    {
        try {
            return DB::select('CALL GetExpiringProducts(?)', [$days]);
        } catch (\Exception $e) {
            Log::error('Fout bij ophalen verlopende producten: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Accessor voor formatted houdbaarheidsdatum
     */
    public function getFormattedHoudbaarheidsdatumAttribute()
    {
        return $this->houdbaarheidsdatum ? $this->houdbaarheidsdatum->format('d-m-Y') : null;
    }

    /**
     * Accessor voor het berekenen van dagen tot vervaldatum
     */
    public function getDagenTotVervaldatumAttribute()
    {
        if (!$this->houdbaarheidsdatum) {
            return null;
        }

        return now()->diffInDays($this->houdbaarheidsdatum, false);
    }
}
