<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'user_id', 'billing_email', 'billing_name', 'billing_address', 'billing_city',
        'billing_province', 'billing_postalcode', 'billing_phone', 'billing_name_on_card',
        'billing_discount', 'billing_discount_code', 'billing_subtotal', 'billing_tax',
        'billing_total', 'payment_gateway', 'shipped', 'error',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    public function presentPrice($price)
    {
        return number_format($price, 2);
    }
}
