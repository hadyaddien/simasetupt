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
        Schema::create('detail_asset_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detail_asset_id')
                ->nullable()
                ->constrained('detail_assets')
                ->nullOnDelete();
            $table->string('event'); // e.g. created, updated, deleted, reported, repaired
            $table->json('changes')->nullable(); // optional data tentang perubahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_asset_histories');
    }
};
