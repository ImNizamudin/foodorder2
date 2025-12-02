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
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->timestamp('ordered_at')->nullable();

            // Tracking fields
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('preparing_at')->nullable();
            $table->timestamp('ready_at')->nullable();
            $table->timestamp('on_the_way_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            // Review fields
            $table->integer('customer_rating')->nullable();
            $table->text('customer_review')->nullable();
            $table->timestamp('reviewed_at')->nullable();

            // Cancellation
            $table->text('cancellation_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'subtotal',
                'ordered_at',
                'confirmed_at',
                'preparing_at',
                'ready_at',
                'on_the_way_at',
                'completed_at',
                'customer_rating',
                'customer_review',
                'reviewed_at',
                'cancellation_reason'
            ]);
        });
    }
};
