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
        Schema::create('leveranciers', function (Blueprint $table) {
            $table->id();
            $table->string('naam');
            $table->string('contact_persoon');
            $table->string('leverancier_nummer')->unique();
            $table->enum('leverancier_type', ['Bedrijf', 'Instelling', 'Overheid', 'Particulier', 'Donor']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leveranciers');
    }
};
