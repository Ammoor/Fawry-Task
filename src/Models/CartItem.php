<?php

namespace Src\Models;

class CartItem
{
    private Product $product;
    private int $quantity;
    public function __construct(Product $product, int $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }
    public function getProduct(): Product
    {
        return $this->product;
    }
    public function getQuantity(): int
    {
        return $this->quantity;
    }
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
    public function getSubtotal(): float
    {
        return $this->product->getPrice() * $this->quantity;
    }
}
