<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('products')->orderByDesc('created_at')->get(); // fix n + 1 issues

        return view('admin.orders')->with('orders', $orders);
    }


    public function show(Order $order)
    {
        $products = $order->products;

        return view('admin.orders.order')->with([
            'order' => $order,
            'products' => $products,
        ]);
    }


    public function updateOrder(Order $order)
    {
        $order->save([$order->shipped = request()->shipped]);
    }

    public function shipOrder(Order $order)
    {
        $order->save([$order->shipped = 1]);
    }

    public function stopShipOrder(Order $order)
    {
        $order->save([$order->shipped = 0]);
    }

    public function shipOrders()
    {
        $ids = request()->ids;
        Order::whereIn("id", explode(",", $ids))->update(['shipped' => 1]);
    }


    public function deleteOrders(Request $request)
    {
        $ids = $request->ids;
        Order::whereIn('id', explode(",", $ids))->delete();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
