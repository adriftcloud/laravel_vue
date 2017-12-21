<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Products
 *
 * @property-read mixed $text
 * @mixin \Eloquent
 * @property int $id
 * @property string $item_code
 * @property string $description
 * @property float $unit_price
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Products whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Products whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Products whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Products whereItemCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Products whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Products whereUpdatedAt($value)
 */
class Products extends Model
{
    protected $fillable = [
        'description', 'unit_price'
    ];

    protected $appends = ['text'];

    public function getTextAttribute()
    {
        return $this->attributes['item_code'] . '-' . $this->attributes['description'];
    }
}
