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
        if (!Schema::hasTable('invoices')) {
            Schema::create('invoices', function (Blueprint $table) {
                $table->id();

                // Core invoice fields
                $table->date('invoice_date');                      // Date of invoice
                $table->decimal('amount', 64, 2);                  // Numeric amount
                $table->string('amount_in_words');                 // Amount in words
                $table->string('payment_month');                   // For which month (e.g., July 2025)
                $table->string('receiver_name');                   // To whom
                $table->string('sender_name');                     // From whom
                $table->string('transaction_number')->nullable();  // Link to transaction

                // Optional approval section
                $table->string('sign_1_name')->nullable();
                $table->string('sign_2_name')->nullable();
                $table->string('sign_3_name')->nullable();

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
