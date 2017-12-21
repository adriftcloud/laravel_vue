<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\InvoiceItem
 *
 * @property-read \App\Model\Products $product
 * @mixin \Eloquent
 * @property int $id
 * @property int $invoice_id
 * @property int $product_id
 * @property int $unit_price
 * @property int $qty
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\InvoiceItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\InvoiceItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\InvoiceItem whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\InvoiceItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\InvoiceItem whereQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\InvoiceItem whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\InvoiceItem whereUpdatedAt($value)
 */
class InvoiceItem extends Model
{
    protected $fillable = [
        'product_id', 'unit_price', 'qty'
    ];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
