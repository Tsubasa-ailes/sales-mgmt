<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalesOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return[
            'id'            => $this->id,
            'order_no'      => $this->invoice?->invoice_no ?? null,
            'customer'      => $this->partner->name,
            'ordered_at'    => $this->ordered_at->format('Y-m-d'),
            'status'        => $this->status,
            'subtotal'      => (float)$this->subtotal,
            'tax_total'     => (float)$this->tax_total,
            'total'         => (float)$this->total,
            'items'         => $this->items->map(fn($i) => [
                'product'       => $i->product->name,
                'qty'           => (float)$i->qty,
                'unit_price'    => (float)$i->unit_price,
            ]),
        ];
    }
}
