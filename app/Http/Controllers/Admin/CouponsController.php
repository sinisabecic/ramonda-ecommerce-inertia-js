<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use App\Jobs\UpdateCoupon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    public function index()
    {
        return view('admin.coupons', ['coupons' => Coupon::all()]);
    }

    public function edit($id)
    {
        return view('admin.coupons.edit', [
            'coupon' => Coupon::findOrFail($id),
        ]);
    }

    public function addPercentDiscount(Request $request)
    {
        Coupon::create([
            'code' => $request->input('code'),
            'type' => 'percent',
            'percent_off' => $request->input('percent_off'),
        ]);
    }

    public function addFixedDiscount(Request $request)
    {
        Coupon::create([
            'code' => $request->input('code'),
            'type' => 'fixed',
            'value' => $request->input('value')
        ]);
    }


    public function update(Coupon $coupon)
    {
        $inputs = request()->validate([
            'code' => ['required', 'string', 'max:255'],
            'percent_off' => '',
            'value' => '',
            'type' => ['required'],
        ]);

        $coupon->save(
            [
                $coupon->code = $inputs['code'],
                $coupon->percent_off = $inputs['percent_off'],
                $coupon->value = $inputs['value'],
                $coupon->type = $inputs['type'],
            ]);
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return response()->json(['message' => 'Item deleted']);
    }


    public function deleteCoupons(Request $request)
    {
        $ids = $request->ids;
        Coupon::whereIn('id', explode(",", $ids))->delete();
    }
}
