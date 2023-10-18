<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class Cart
{
    protected $items;

    public function __construct()
    {
        $this->items = collect(Session::get('cart.items', []));
    }

    public function add(Product $product, int $quantity = 1): void
    {
        $item = $this->items->first(function ($item) use ($product) {
            return $item['product_id'] === $product->id;
        });

        if ($item) {
            $item['quantity'] += $quantity;
        } else {
            $this->items->push([
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image,
            ]);
        }

        $this->save();
    }

    public function update(int $productId, int $quantity): void
    {
        $item = $this->items->first(function ($item) use ($productId) {
            return $item['product_id'] === $productId;
        });

        if ($item) {
            $item['quantity'] = $quantity;
            $this->save();
        }
    }

    public function remove(int $productId): void
    {
        $this->items = $this->items->filter(function ($item) use ($productId) {
            return $item['product_id'] !== $productId;
        });

        $this->save();
    }

    public function clear(): void
    {
        $this->items = collect();
        $this->save();
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function getTotal(): float
    {
        return $this->items->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function getSubtotal(): float
    {
        return $this->getTotal();
    }

    public function getTax(): float
    {
        return $this->getSubtotal() * 0.08; // 8% tax rate
    }

    public function getTotalWithTax(): float
    {
        return $this->getSubtotal() + $this->getTax();
    }

    public function getItemCount(): int
    {
        return $this->items->sum('quantity');
    }

    protected function save(): void
    {
        Session::put('cart.items', $this->items->toArray());
    }
}
