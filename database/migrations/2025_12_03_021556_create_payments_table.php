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
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('appointment_id')->constrained('appointments')->onDelete('cascade');
        $table->integer('total_price')->nullable();
        $table->string('payment_status')->default('pending'); // pending / paid
        $table->string('invoice_id')->nullable();
        $table->string('qr_path')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('payments');
}

};
