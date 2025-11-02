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
            $table->foreignId('sales_order_id')->constrained();
            $table->string('invoice_no')->unique();
            $table->date('issued_at'); //請求日
            $table->date('due_on')->nullable(); //支払期限日
            $table->decimal('subtotal', 14, 2);
            $table->decimal('tax_total', 14, 2);
            $table->decimal('total', 14, 2);
            $table->string('pdf_path')->nullable();
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
