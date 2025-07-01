<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
        DROP PROCEDURE IF EXISTS SP_GetVoedselPakkettenByGezin;
            CREATE PROCEDURE SP_GetVoedselPakkettenByGezin()
            BEGIN
                SELECT 
                    vp.id AS voedselpakket_id,
                    vp.pakket_nummer,
                    vp.datum_samenstelling,
                    vp.datum_uitgifte,
                    vp.status,
                    g.naam AS gezinsnaam,
                    g.omschrijving,
                    g.aantal_volwassenen AS volwassenen,
                    g.aantal_kinderen AS kinderen,
                    g.aantal_babys AS babys,
                    CONCAT(
                        p.voornaam, 
                        CASE 
                            WHEN p.tussenvoegsel IS NOT NULL THEN CONCAT(" ", p.tussenvoegsel, " ") 
                            ELSE " " 
                        END,
                        p.achternaam
                    ) AS vertegenwoordiger,
                    e.naam AS eetwens_naam
                FROM voedselpakketten vp
                INNER JOIN gezinnen g ON vp.gezin_id = g.id
                LEFT JOIN personen p ON g.id = p.gezin_id AND p.is_vertegenwoordiger = 1
                LEFT JOIN eetwens_per_gezin epg ON g.id = epg.gezin_id
                LEFT JOIN eetwensen e ON epg.eetwens_id = e.id
                ORDER BY vp.datum_samenstelling DESC, g.naam;
            END;


            DROP PROCEDURE IF EXISTS SP_GetVoedselPakketten;
            CREATE PROCEDURE SP_GetVoedselPakketten()
            BEGIN
                SELECT 
                    g.naam AS naam,
                    g.omschrijving AS omschrijving,
                    g.totaal_aantal_personen AS totaal_aantal_personen,
                    vp.pakket_nummer,
                    vp.datum_samenstelling,
                    vp.datum_uitgifte,
                    vp.status,
                    COALESCE(product_count.aantal_producten, 0) AS aantal_producten
                FROM voedselpakketten vp
                INNER JOIN gezinnen g ON vp.gezin_id = g.id
                LEFT JOIN (
                    SELECT 
                        voedselpakket_id,
                        COUNT(*) AS aantal_producten
                    FROM product_per_voedselpakket
                    GROUP BY voedselpakket_id
                ) product_count ON vp.id = product_count.voedselpakket_id
                ORDER BY vp.datum_samenstelling DESC, g.naam;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS SP_GetVoedselPakkettenByGezin');
        DB::unprepared('DROP PROCEDURE IF EXISTS SP_GetVoedselPakketten');
    }
};
