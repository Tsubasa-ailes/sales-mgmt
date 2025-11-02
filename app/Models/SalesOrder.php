<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    protected $fillable = ['partner_id','ordered_at','status','subtotal','tax_total','total'];
    public function partner(){ return $this->belongTo(BusinessPartner::class, 'partner_id'); }
    public function items(){ return $this->hasMany(SalesItem::class); } 
    public function invoice(){ return $this->hasOne(Invoice::class); }
}
