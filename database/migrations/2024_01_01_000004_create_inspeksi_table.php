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
        Schema::create('inspeksi', function (Blueprint $table) {
            $table->id('id_inspeksi');
            $table->string('id_apar', 50);
            $table->foreignId('id_user')->constrained('users')->onDelete('restrict');
            $table->date('tanggal_inspeksi');
            $table->date('next_inspection')->nullable();
            
            // Checklist items
            $table->enum('pressure_status', ['hijau', 'kuning', 'merah'])->default('hijau');
            $table->enum('physical_condition', ['baik', 'kurang', 'rusak'])->default('baik');
            $table->boolean('seal_condition')->default(true);
            $table->boolean('hose_condition')->default(true);
            $table->boolean('nozzle_condition')->default(true);
            $table->boolean('handle_condition')->default(true);
            $table->boolean('label_condition')->default(true);
            $table->boolean('signage_condition')->default(true);
            $table->boolean('height_position')->default(true); // 1-1.5m dari lantai
            $table->boolean('accessibility')->default(true); // Min 1 meter akses
            $table->boolean('cleanliness')->default(true);
            
            // Overall result
            $table->enum('overall_status', ['baik', 'kurang', 'rusak'])->default('baik');
            $table->text('catatan')->nullable();
            $table->string('photo_path')->nullable();
            $table->string('signature_path')->nullable();
            $table->timestamps();

            $table->foreign('id_apar')->references('id_apar')->on('apar')->onDelete('cascade');
            
            $table->index('tanggal_inspeksi');
            $table->index('overall_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspeksi');
    }
};
