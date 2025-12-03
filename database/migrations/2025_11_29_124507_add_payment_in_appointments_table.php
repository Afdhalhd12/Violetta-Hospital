<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->default('onsite');
            $table->integer('total_price')->nullable();
            $table->string('payment_status')->default('pending');
            $table->string('invoice_id')->nullable(); // opsional
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn([
                'payment_method',
                'total_price',
                'payment_status',
                'invoice_id'
            ]);
        });
    }
};
