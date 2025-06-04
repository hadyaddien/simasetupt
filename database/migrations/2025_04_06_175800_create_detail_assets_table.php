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
        Schema::create('detail_assets', function (Blueprint $table) {
            $table->id();
            $table->string('code_asset')->unique()->nullable(false);
            $table->foreignId('asset_id')->constrained()->onDelete('cascade');
            $table->foreignId('room_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('division_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('condition', ['good', 'minor_damage', 'not_functional'])->nullable();
            $table->enum('asset_status', ['in_warehouse', 'in_use', 'in_repair', 'disposed'])->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_assets');
    }
};
