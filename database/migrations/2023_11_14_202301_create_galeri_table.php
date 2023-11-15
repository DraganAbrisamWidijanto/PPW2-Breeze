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
        Schema::table('galeri', function (Blueprint $table) {
            $table->string('path')->nullable();
        });

        Schema::create('galeri', function (Blueprint $table) {
            $table->id();
            $table->string('nama_galeri');
            $table->string('galeri_seo')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('foto');
            $table->string('path')->nullable();
            $table->unsignedBigInteger('buku_id');
            $table->foreign('buku_id')
                ->references('id')
                ->on('buku')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galeri', function (Blueprint $table) {
            $table->dropColumn('path');
        });

        Schema::dropIfExists('galeri');
    }
};
