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
        Schema::create('lokasi', function (Blueprint $table) {
            $table->id('id_lokasi');
            $table->string('nama_lokasi');
            $table->string('gedung');
            $table->string('lantai');
            $table->string('ruangan');
            $table->string('koordinat')->nullable();
            $table->enum('kategori_risiko', ['rendah', 'sedang', 'tinggi'])->default('sedang');
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->index(['gedung', 'lantai']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasi');
    }
};
