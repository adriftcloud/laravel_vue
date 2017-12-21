<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Customer
 *
 * @property-read mixed $text
 * @mixin \Eloquent
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $address
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Customer whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Customer whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Customer whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Customer whereUpdatedAt($value)
 */
class Customer extends Model
{
    protected $fillable = [
        'firstname', 'lastname', 'address', 'email'
    ];

    protected $appends = ['text'];

    public function getTextAttribute()
    {
        return $this->attributes['firstname'] . '-' . $this->attributes['lastname'];
    }
}
