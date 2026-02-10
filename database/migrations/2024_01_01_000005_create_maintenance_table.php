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
        Schema::create('maintenance', function (Blueprint $table) {
            $table->string('wo_number', 50)->primary(); // WO-2024-0001
            $table->string('id_apar', 50);
            $table->foreignId('teknisi_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('supervisor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->date('scheduled_date');
            $table->date('completed_date')->nullable();
            $table->enum('maintenance_type', ['ringan', 'sedang', 'berat']);
            $table->text('work_description')->nullable();
            $table->text('material_used')->nullable();
            $table->decimal('cost', 12, 2)->default(0);
            $table->string('before_photo')->nullable();
            $table->string('after_photo')->nullable();
            $table->boolean('supervisor_approval')->default(false);
            $table->date('approval_date')->nullable();
            $table->text('approval_notes')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();

            $table->foreign('id_apar')->references('id_apar')->on('apar')->onDelete('cascade');
            
            $table->index('status');
            $table->index('scheduled_date');
            $table->index('maintenance_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance');
    }
};
