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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id'); 
             $table->unsignedBigInteger('employee_id'); 
            $table->string('bill_number')->unique();               
            $table->date('bill_date');                             
            $table->decimal('total_amount', 15, 2)->default(0); 
            $table->enum('status', ['draft', 'unpaid', 'partially paid', 'paid', 'sent'])->default('unpaid');   
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('employee_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
