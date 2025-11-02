<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\{Product, SalesOrder, SalesItem, StockMovement, Invoice};
use App\Services\InventoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\validation\validationExeption;
use Throwable;

class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SalesOrderStoreRequest $request): JsonResponse
    {
        $data = $request->validated(); //安全なデータのみ取得

        try{
            $so = DB::transaction(function()use($data){
                $so = SalesOrder::create(Arr::only($data, ['partner_id','ordered_at']));
                $subtotal = 0; $taxTotal = 0;

                foreach($data['items'] as $row){
                    $product = Product::findOrFail($row['product_id']);
                    // 排他制御
                    $onHand = InventoryService::qtyOnHandForUpdate($product->id, $data['warehouse_id']);
                    if($onHand < $row['qty']){
                        throw ValidationException::withMessages([
                            'items' => "在庫不足: {$product->name}(必要 {$row['qty']} / 在庫{$onHand}) "
                        ]);
                    }

                    //明細作成
                    $item = $so->items()->create([
                        'product_id' => $product->id,
                        'qty'        => (float)$row['qty'],
                        'unit_price' => (float)$row['unit_price'],
                        'tax_rate'   => (float)$product->tax_rate,
                    ]);

                    //出庫(確定=即時出庫MVP)
                    StockMovement::create([
                        'product_id'   => $product->id,
                        'warehouse_id' => $data['warehouse_id'],
                        'qty'          => (float)$row['qty'],
                        'type'         => 'OUT',
                        'ref_type'     => 'sales',
                        'ref_id'       => $so->id,
                    ]);

                    $line = $item->qty * $item->unit_price;
                    $tax = round($line * ($item->tax_rate / 100), 2);

                    $subtotal += $line;
                    $taxTotal += $tax;
                }

                $so->update([
                    'status'    => 'confirmed',
                    'subtotal'  => round($subtotal, 2),
                    'tax_total' => round($taxTotal, 2),
                    'total'     => round($subtotal + $talTotal, 2),
                ]);

                // 必要ならここでイベント発火（通知や請求ドラフト作成など）
                // event(new SalesOrderConfirmed($so));
                return $so->load('items');  
            });
            return response()->json($so->load('items'), 201);
        } catch (ValidationException $e) {
            throw $e; // バリデーションはそのまま返す
        } catch (Throwable $e) {
            report($e);
            return response()->json([
                'message' => '受注登録でエラーが発生しました。'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
