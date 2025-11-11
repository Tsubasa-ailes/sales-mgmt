<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BusinessPartner;
use App\Models\Warehouse;
use App\Models\SalesItem;

class SalesOrder extends Model
{
    use HasFactory;

    protected $fillable = ['partner_id','ordered_at','status','subtotal','tax_total','total'];
    public function partner(){ return $this->belongsTo(BusinessPartner::class, 'partner_id'); }
    public function items(){ return $this->hasMany(SalesItem::class); } 
    public function invoice(){ return $this->hasOne(Invoice::class); }
}
