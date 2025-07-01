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
        Schema::create('voedselpakketten', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gezin_id')->constrained('gezinnen')->onDelete('cascade');
            $table->integer('pakket_nummer');
            $table->date('datum_samenstelling');
            $table->date('datum_uitgifte')->nullable();
            $table->enum('status', ['Uitgereikt', 'NietUitgereikt', 'NietMeerIngeschreven']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voedselpakketten');
    }
};
