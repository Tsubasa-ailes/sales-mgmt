<?php

namespace App\Services;

use App\Models\StockMovement;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

// 在庫残量を計算するサービスクラス
class InventoryService
{
    public static function qtyOnHandForUpdate(int $productId, int $warehouseId): float
    {
        DB::statement('SET TRANSACTION ISOLATION LEVEL READ COMMITED');

        $qty = StockMovement::where('product_id', $productId)
            ->where('warehouse_id', $warehouseId)
            ->lockForUpdate()
            // typeが'IN'の時はプラス、'OUT'の時はマイナス
            ->selectRaw("COALESCE(SUM(CASE WHEN type = 'IN' THEN qty ELSE -qty END), 0) AS qty")
            ->value('qty');

        return (float)($qty ?? 0);
    }
}