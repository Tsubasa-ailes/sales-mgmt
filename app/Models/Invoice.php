<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'sales_order_id',
        'invoice_no',
        'issued_at',
        'due_on',
        'subtotal',
        'tax_total',
        'total',
        'pdf_path',
    ];

    protected $casts = [
        'issued_at' => 'date',
        'due_on'    => 'date',
        'subtotal'  => 'decimal:2',
        'tax_total' => 'decimal:2',
        'total'     => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongTo(SalesOrder::class, 'sales_order_id');
    }
}
