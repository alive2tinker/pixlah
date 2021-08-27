<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Screen;
use App\Events\OrderHasBeenServed;
use App\Events\OrderIsServing;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    public function orderIsServed(Order $order)
    {
        $order->update([
            'status' => "served"
        ]);

        event(new OrderHasBeenServed($order));

        return redirect()->back()->with('success', "screen updated successfully");
    }

    public function orderIsServing(Order $order)
    {
        $order->update([
            'status' => "serving"
        ]);

        event(new OrderIsServing($order));

        return redirect()->back()->with('success', "screen updated successfully");
    }

    public function updateOrders(Screen $screen)
    {
        $orders = Order::where([
            ['screen_id', $screen->id],
            ['status', '!=', 'served']
        ])->take(8)->get();

        return OrderResource::collection($orders);
    }
}
