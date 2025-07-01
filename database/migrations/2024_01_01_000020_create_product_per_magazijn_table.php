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
        Schema::create('product_per_magazijn', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('producten')->onDelete('cascade');
            $table->foreignId('magazijn_id')->constrained('magazijnen')->onDelete('cascade');
            $table->string('locatie');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_per_magazijn');
    }
};
