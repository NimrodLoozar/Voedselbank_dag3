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
        Schema::create('product_per_voedselpakket', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voedselpakket_id')->constrained('voedselpakketten')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('producten')->onDelete('cascade');
            $table->integer('aantal_product_eenheden');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_per_voedselpakket');
    }
};
