<?php

use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;

function presentPrice($price)
{
    return number_format($price, 2);
}


function presentDate($date)
{
    return Carbon::parse($date)->format('d M, Y');
}

function setActiveCategory($category, $output = 'active')
{
    return request()->category == $category ? $output : '';
}

//function productImage($path)
//{
//    return $path && file_exists('storage/' . $path) ? asset('storage/' . $path) : asset('img/not-found.jpg');
//}

function productImage($slug, $image)
{
    return env('PRODUCT_IMG') . '/' . $slug . '/' . $image ?
        env('PRODUCT_IMG') . '/' . $slug . '/' . $image
        : env('PRODUCT_IMG') . '/default/' . $image;
}

function getNumbers()
{
    $tax = config('cart.tax') / 100;
    $discount = session()->get('coupon')['discount'] ?? 0; //in Order
    $code = session()->get('coupon')['name'] ?? null;
    $newSubtotal = (presentPrice(Cart::subtotal()) - $discount);
    if ($newSubtotal < 0) {
        $newSubtotal = 0;
    }
    $newTax = $newSubtotal * $tax;
    $newTotal = $newSubtotal * (1 + $tax); // 1 + 0.21

    return collect([
        'tax' => $tax,
        'discount' => $discount,
        'code' => $code,
        'newSubtotal' => $newSubtotal,
        'newTax' => $newTax,
        'newTotal' => $newTotal,
    ]);
}

function getStockLevel($quantity)
{
    if ($quantity > 5) {
        $stockLevel = '<div class="badge badge-success">In stock</div>';
    } elseif ($quantity <= 5 && $quantity > 0) {
        $stockLevel = '<div class="badge badge-warning">Low stock</div>';
    } else {
        $stockLevel = '<div class="badge badge-danger">Not available</div>';
    }

    return $stockLevel;
}
