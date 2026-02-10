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
        Schema::create('training', function (Blueprint $table) {
            $table->id('id_training');
            $table->string('nama_training');
            $table->date('tanggal_training');
            $table->string('tempat');
            $table->string('instruktur');
            $table->text('materi')->nullable();
            $table->timestamps();
        });

        // Pivot table for users training
        Schema::create('training_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_training')->constrained('training', 'id_training')->onDelete('cascade');
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->boolean('kehadiran')->default(false);
            $table->decimal('nilai', 5, 2)->nullable();
            $table->string('sertifikat_path')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['id_training', 'id_user']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_user');
        Schema::dropIfExists('training');
    }
};
