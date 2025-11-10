<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesItem extends Model
{
    protected $fillable = [
        'sales_order_id','product_id','qty','unit_price','tax_rate'
    ];

    public function order() {
        return $this->belongsTo(SalesOrder::class, 'sales_order_id');
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
