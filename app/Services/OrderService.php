<?php


namespace App\Services;

use App\Models\BookedRoom;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Carbon\Carbon;


class OrderService
{
    public function saveOrder($data)
    {
        $order = $this->orderStore($data);
        $this->orderDetailsStore($order);
        $this->bookedRoomsStore($order);
    }
    public function orderStore($data)
    {
        $order = Order::create($data);
        return $order;
    }
    public function orderDetailsStore($order)
    {
        $cartItems = Cart::where('user_id', auth()->id())->get();
        foreach ($cartItems as $cartItem) {
            OrderDetail::create([
                'order_id' => $order->id,
                'room_id' => $cartItem->room_id,
                'order_no' => $order->order_no,
                'checkin_date' => $cartItem->checkin,
                'checkout_date' => $cartItem->checkout,
                'adults' => $cartItem->adults,
                'children' => $cartItem->children ?? 0,
                'subtotal' => $cartItem->subtotal,
            ]);
        }
    }
    public function bookedRoomsStore($order)
    {
        $cartItems = Cart::where('user_id', auth()->id())->get(); 

        foreach ($cartItems as $cartItem) {
            $checkin = Carbon::parse($cartItem->checkin);
            $checkout = Carbon::parse($cartItem->checkout);

            // تكرار لكل يوم بين checkin و checkout
            for ($date = $checkin; $date->lt($checkout); $date->addDay()) {
                BookedRoom::create([
                    'room_id' => $cartItem->room_id,
                    'order_no' => $order->order_no,
                    'booking_date' => $date->toDateString(), // تخزين كل يوم بشكل منفصل
                ]);
            }
        }
    }
}
