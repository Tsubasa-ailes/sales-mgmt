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
        // 受注マスタ(ヘッダ情報)
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('business_partners');
            $table->date('ordered_at');
            $table->enum('status', ['draft','confirmed','cancelled'])->default('draft');
            $table->decimal('subtotal', 14, 2)->default(0);
            $table->decimal('tax_total', 14, 2)->default(0);
            $table->decimal('total', 14, 2)->default(0);
            $table->timestamps();
        });
        // 受注マスタ（明細テーブル）
        Schema::create('sales_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_order_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->decimal('qty', 12, 3);
            $table->decimal('unit_price', 12, 2);
            $table->decimal('tax_rate', 4, 2)->default('10.00');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
