<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Helper\HasManyRelation;

/**
 * App\Model\Invoice
 *
 * @property-read \App\Model\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\InvoiceItem[] $items
 * @property-write mixed $sub_total
 * @mixin \Eloquent
 * @property int $id
 * @property string $number
 * @property int $customer_id
 * @property string $date
 * @property string $due_date
 * @property string|null $reference
 * @property string $terms_and_conditions
 * @property float $discount
 * @property float $total
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Invoice whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Invoice whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Invoice whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Invoice whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Invoice whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Invoice whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Invoice whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Invoice whereTermsAndConditions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Invoice whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Invoice whereUpdatedAt($value)
 */
class Invoice extends Model
{
    use HasManyRelation;

    protected $fillable = [
        'customer_id', 'date', 'due_date', 'terms_and_conditions', 'discount'
    ];

    protected $guarded = [
        'number', 'sub_total', 'total'
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }


    /**
     * 定義 sub_total 修改器
     * @param $value
     */
    public function setSubTotalAttribute($value)
    {
        //設定 sub_total 欄位值
        $this->attributes['sub_total'] = $value;
        $discount = $this->attributes['discount'];
        $this->attributes['total'] = $value - $discount;
    }
}
