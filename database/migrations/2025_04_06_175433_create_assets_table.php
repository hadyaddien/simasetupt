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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('source_id')->nullable()->constrained('sources')->onDelete('cascade');
            $table->string('name');
            $table->string('brand')->nullable();
            $table->text('specification')->nullable();
            $table->year('production_year')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->enum('unit', ['pcs', 'unit', 'pack',  'set', 'box'])->nullable();
            $table->string('picture')->nullable();
            $table->integer('quantity')->default(1);
            $table->string('recipient_name')->nullable();
            $table->date('received_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
