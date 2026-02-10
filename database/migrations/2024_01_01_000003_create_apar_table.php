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
        Schema::create('apar', function (Blueprint $table) {
            $table->string('id_apar', 50)->primary();
            $table->string('kode_qr', 100)->unique();
            $table->enum('tipe_apar', ['powder', 'co2', 'foam', 'liquid']);
            $table->decimal('kapasitas', 5, 2);
            $table->string('merk');
            $table->string('no_seri')->nullable();
            $table->date('tanggal_produksi');
            $table->date('tanggal_pengisian')->nullable();
            $table->date('tanggal_expire');
            $table->unsignedBigInteger('id_lokasi');
            $table->unsignedBigInteger('id_vendor')->nullable();
            $table->enum('status', ['aktif', 'rusak', 'expired', 'maintenance', 'disposed'])->default('aktif');
            $table->string('foto')->nullable();
            $table->timestamps();

            $table->foreign('id_lokasi')->references('id_lokasi')->on('lokasi')->onDelete('restrict');
            $table->foreign('id_vendor')->references('id_vendor')->on('vendor')->onDelete('set null');

            $table->index('status');
            $table->index('tanggal_expire');
            $table->index('tipe_apar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apar');
    }
};
