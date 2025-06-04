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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('damage_report_id')->constrained('damage_reports')->cascadeOnDelete();
            $table->decimal('repair_cost', 15, 2)->nullable();
            $table->decimal('replace_cost', 15, 2)->nullable();
            $table->enum('status_approv', ['allow_repair', 'allow_replace', 'dispose'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
