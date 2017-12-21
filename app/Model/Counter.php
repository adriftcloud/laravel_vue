<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Counter
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $key
 * @property string $prefix
 * @property string $value
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Counter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Counter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Counter whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Counter wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Counter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Counter whereValue($value)
 */
class Counter extends Model
{
    protected $fillable = [
        'key', 'prefix', 'value'
    ];
}
