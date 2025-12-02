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
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('payment_method', ['cash', 'card', 'digital_wallet'])->default('cash');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->enum('delivery_time', ['asap', 'schedule'])->default('asap');
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_status', 'delivery_time', 'delivery_fee', 'tax_amount']);
        });
    }
};
