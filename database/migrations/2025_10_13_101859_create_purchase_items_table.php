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
        //入庫商品マスタ
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')
                ->constrained('purchase_orders')
                ->cuscadeOnDelete();
            $table->foreignId('product_id')
                ->constrained('products');
            // 明細ごとの入庫先（指定があればこちらを優先）
            $table->foreignId('warehouse_id')
                ->constrained('warehouses');
            // 数量/単価/税率
            $table->decimal('qty', 12, 3);
            $table->decimal('unit_price', 12, 2);
            $table->decimal('tax_rate', 4, 2)->default('10.00');
            $table->decimal('received_qty', 12, 3)->default(0); //入荷済数量
            $table->decimal('inspected_qty', 12, 3)->default(0); //検収済数量
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};
