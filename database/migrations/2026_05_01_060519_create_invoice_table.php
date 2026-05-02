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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->string('invoice_number')->unique();
            $table->date('invoice_date');
            $table->date('due_date');

             // Seller
            $table->string('seller_name');
            $table->text('seller_address');
            $table->string('seller_gstin')->nullable();
            $table->string('seller_pan')->nullable();

             // Customer
            $table->string('customer_name');
            $table->text('customer_address');
            $table->string('customer_gstin')->nullable();
            $table->string('customer_pan')->nullable();

             // Supply
            $table->string('place_of_supply')->nullable();
            $table->string('country_of_supply')->nullable();

            // Amounts
            $table->decimal('subtotal', 12, 2);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('taxable_amount', 12, 2);
            $table->decimal('cgst', 12, 2)->default(0);
            $table->decimal('sgst', 12, 2)->default(0);
            $table->decimal('total', 12, 2);
            $table->decimal('early_payment_discount', 12, 2)->nullable();
            $table->decimal('final_amount', 12, 2)->nullable();

            // Payment Details
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('ifsc')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_type')->nullable();
            $table->string('upi')->nullable();


             $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
