<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()
            ->with(['items.product'])
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.product']);
        return view('orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        if (Cart::isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $request->validate([
            'shipping_address' => 'required|string',
            'billing_address' => 'required|string'
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => Cart::getTotal(),
            'status' => 'pending',
            'shipping_address' => $request->shipping_address,
            'billing_address' => $request->billing_address
        ]);

        foreach (Cart::getContent() as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'quantity' => $item->quantity,
                'price' => $item->price
            ]);

            // Update product stock
            $product = Product::find($item->id);
            $product->decrement('stock', $item->quantity);
        }

        Cart::clear();

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order placed successfully.');
    }
}
