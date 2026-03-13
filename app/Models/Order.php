<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'subtotal',
        'grand_total',
        'shipping',
        'discount',
        'payment_status',
        'status',
        'name',
        'email',
        'mobile',
        'address',
        'city',
        'state',
        'zip',

    ];
    function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:d M,Y',
        ];
    }
}
