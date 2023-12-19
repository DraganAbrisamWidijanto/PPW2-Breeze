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
    Schema::create('bukus', function (Blueprint $table) {
        $table->id();
        // ... other columns
        $table->timestamps();
    });

    // Add index to the 'id' column in 'bukus' table
    Schema::table('bukus', function (Blueprint $table) {
        $table->index('id');
    });

    Schema::create('buku_kategori_buku', function (Blueprint $table) {
        $table->id();
        $table->foreignId('buku_id')->constrained();
        $table->foreignId('kategori_buku_id')->constrained();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku_kategori_buku');
    }
};
