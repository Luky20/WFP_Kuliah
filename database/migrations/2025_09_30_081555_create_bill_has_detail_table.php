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
        Schema::create('bill_has_detail', function (Blueprint $table) {
            $table->foreignId('bill_id')
                  ->constrained('bills')
                  ->cascadeOnDelete();

            $table->foreignId('food_id')
                  ->constrained('foods')
                  ->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('price', 8, 2);
            $table->primary(['bill_id', 'food_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_has_detail');
    }
};
