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
    Schema::table('appointments', function (Blueprint $table) {
        $table->dropColumn([
            'payment_status',
            'invoice_id',
            'qr_path',
            'total_price',
        ]);
    });
}

public function down(): void
{
    Schema::table('appointments', function (Blueprint $table) {
        $table->integer('total_price')->nullable();
        $table->string('payment_status')->default('pending');
        $table->string('invoice_id')->nullable();
        $table->string('qr_path')->nullable();
    });
}

};
