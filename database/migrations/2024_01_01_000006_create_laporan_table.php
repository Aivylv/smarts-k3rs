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
        Schema::create('laporan', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->foreignId('id_user')->constrained('users')->onDelete('restrict');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->integer('total_apar')->default(0);
            $table->integer('total_inspeksi')->default(0);
            $table->integer('apar_baik')->default(0);
            $table->integer('apar_rusak')->default(0);
            $table->integer('apar_expired')->default(0);
            $table->integer('apar_maintenance')->default(0);
            $table->decimal('compliance_rate', 5, 2)->default(0); // Percentage
            $table->string('file_path')->nullable();
            $table->enum('status_laporan', ['draft', 'published'])->default('draft');
            $table->timestamps();

            $table->unique(['bulan', 'tahun']);
            $table->index('tahun');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
