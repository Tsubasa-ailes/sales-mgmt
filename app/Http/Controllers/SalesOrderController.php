<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\SalesOrderStoreRequest;
use App\Models\{Product, SalesOrder, SalesItem, StockMovement, Invoice, BusinessPartner, Warehouse};
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
        $orders = SalesOrder::with('partner')->orderByDesc('ordered_at')->get();
        return view('sales_orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $partners = BusinessPartner::orderBy('name')->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();
        $warehouses = Warehouse::orderBy('name')->get();
        return view('sales_orders.create', compact('partners', 'products', 'warehouses'));
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(SalesOrderStoreRequest $request)
{
    // バリデーション済みデータのみ取得
    $data = $request->validated();

    DB::transaction(function () use ($data) {
        $subtotal = $tax_total = 0; // 初期化

        // ヘッダー登録
        $order = SalesOrder::create([
            'partner_id' => $data['partner_id'],
            'ordered_at' => $data['ordered_at'],
            'status'     => 'confirmed',
            'subtotal'   => 0,
            'tax_total'  => 0,
            'total'      => 0,
        ]);

        // 明細ループ
        foreach ($data['items'] as $item) {
            $line_subtotal = $item['qty'] * $item['unit_price'];
            $line_tax = $line_subtotal * ($item['tax_rate'] / 100);

            $subtotal  += $line_subtotal;
            $tax_total += $line_tax;

            SalesItem::create([
                'sales_order_id' => $order->id,
                'product_id'     => $item['product_id'],
                'qty'            => $item['qty'],
                'unit_price'     => $item['unit_price'],
                'tax_rate'       => $item['tax_rate'],
            ]);
        }

        $order->update([
            'subtotal'  => $subtotal,
            'tax_total' => $tax_total,
            'total'     => $subtotal + $tax_total,
        ]);
    });

    return redirect()->route('sales_orders.index')
        ->with('status', '受注を登録しました。');
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
