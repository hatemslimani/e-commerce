<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }

    public function add(Request $request, Product $product)
    {
        if (!$product->is_active) {
            return redirect()->back()->with('error', 'Product is not available.');
        }

        if ($product->stock < 1) {
            return redirect()->back()->with('error', 'Product is out of stock.');
        }

        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'attributes' => [
                'image' => $product->image
            ]
        ]);

        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock
        ]);

        Cart::update($product->id, [
            'quantity' => [
                'relative' => false,
                'value' => $request->quantity
            ]
        ]);

        return redirect()->back()->with('success', 'Cart updated successfully.');
    }

    public function remove(Product $product)
    {
        Cart::remove($product->id);

        return redirect()->back()->with('success', 'Product removed from cart successfully.');
    }

    public function clear()
    {
        Cart::clear();

        return redirect()->back()->with('success', 'Cart cleared successfully.');
    }
}
