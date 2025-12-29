<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\SalesOrder;

class InvoiceController extends Controller
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
    public function create(SalesOrder $order)
    {
        if ($order->invoice) {
            return redirect()
                ->route('invoices.show', $order->invoice->id)
                ->with('status', '既に請求書が発行されています。');
        }
        return view('invoices.create', compact('order'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, SalesOrder $order)
    {
        $validated = $request->validate([
            'invoice_no' => ['required', 'string', 'max:50', 'unique:invoices,invoice_no'],
            'issued_at'  => ['required', 'date'],
            'due_on'     => ['nullable', 'date', 'after_or_equal:issued_at'],
        ]);

        $invoice = Invoice::create([
            'sales_order_id' => $order->id,
            'invoice_no'     => $validated['invoice_no'],
            'issued_at'      => $validated['issued_at'],
            'due_on'         => $validated['due_on'],
            'subtotal'       => $order->subtotal,
            'tax_total'      => $order->tax_total,
            'total'          => $order->total,
            'pdf_path'       => null,
        ]);

        return redirect()
            ->route('sales_orders.show', $order->id)
            ->with('status', '請求書を発行しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice ->load(['order.partner', 'order.items.product']);
        return view('invoices.show', compact('invoice'));
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
