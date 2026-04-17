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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // coupon code
            $table->enum('type', ['fixed', 'percentage']); // discount type
            $table->decimal('value', 10, 2); // discount amount
            $table->decimal('min_purchase', 10, 2)->nullable(); // minimum purchase
            $table->decimal('max_discount', 10, 2)->nullable(); // max discount (for percentage)
            $table->integer('usage_limit')->nullable(); // total usage limit
            $table->integer('used_count')->default(0); // used count
            $table->timestamp('expire_date')->nullable(); // expire date
            $table->boolean('status')->default(1); // active/inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
