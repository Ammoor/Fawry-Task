<?php

namespace Src\Models;

use Exception;

class Cart
{
    private array $items = [];
    public function addProduct(Product $product, int $quantity): bool
    {
        if (!$product->isInStock($quantity)) {
            throw new Exception("Insufficient stock for product: {$product->getName()}");
        }

        if ($product->isExpired()) {
            throw new Exception("Product is expired: {$product->getName()}");
        }

        $productName = $product->getName();

        if (isset($this->items[$productName])) {
            $newQuantity = $this->items[$productName]->getQuantity() + $quantity;
            if (!$product->isInStock($newQuantity)) {
                throw new Exception("Insufficient stock for product: {$product->getName()}");
            }
            $this->items[$productName]->setQuantity($newQuantity);
        } else {
            $this->items[$productName] = new CartItem($product, $quantity);
        }

        return true;
    }
    public function getItems(): array
    {
        return $this->items;
    }
    public function isEmpty(): bool
    {
        return empty($this->items);
    }
    public function getSubtotal(): float
    {
        $subtotal = 0;
        foreach ($this->items as $item) {
            $subtotal += $item->getSubtotal();
        }
        return $subtotal;
    }
    public function clear(): void
    {
        $this->items = [];
    }
}
