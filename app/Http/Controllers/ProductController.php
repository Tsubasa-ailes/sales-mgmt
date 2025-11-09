<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all(); //全件取得
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'tax_rate'   => ['required', 'numeric', 'min:0'],
            'is_active'  => ['required', 'boolean'],
        ]);
        
        // ▼ ここがポイント：SKUの数値部分の MAX を取る
        $maxNumber = Product::selectRaw("MAX(CAST(SUBSTRING(sku, 5) AS UNSIGNED)) as max_num")
            ->value('max_num');

        // まだ1件も無ければ1から開始
        $nextNumber = $maxNumber ? ((int)$maxNumber + 1) : 1;

        // PRD-0001 形式で作る
        $validated['sku'] = 'PRD-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        Product::create($validated);

        return redirect()->route('products.index')->with('status', '商品を登録しました。');
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
