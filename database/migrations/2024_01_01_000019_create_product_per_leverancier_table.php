<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_per_leverancier', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leverancier_id')->constrained('leveranciers')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('producten')->onDelete('cascade');
            $table->date('datum_aangeleverd');
            $table->date('datum_eerst_volgende_levering');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_per_leverancier');
    }
};
