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
        //仕入マスタ
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('partner_id')->constrained('business_partners'); //仕入先
            $table->foreignId('warehouse_id')->constrained('warehouses'); //入庫先
            $table->string('order_no')->unique();    
            $table->date('ordered_at'); //発注日
            $table->date('expected_arrived_at')->nullable(); //納期(予定)
            // ステータス
            // draft=作成中, ordered=発注確定, partially_received=一部入荷, received=全量入荷,
            // closed=検収/支払まで完了, cancelled=キャンセル
            $table->enum('status', [
                'draft','ordered','partially_received','received','closed','cancelled'
            ])->default('draft');
            //金額（税抜/税/税込）
            $table->decimal('subtotal', 14, 2)->default(0);
            $table->decimal('tax_total', 14, 2)->default(0);
            $table->decimal('total', 14, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
