<?php

namespace Src\Services;

use Exception;
use Src\Models\Cart;
use Src\Models\Product;

class CartService
{
    private Cart $cart;
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }
    public function addToCart(Product $product, int $quantity): bool
    {
        try {
            return $this->cart->addProduct($product, $quantity);
        } catch (Exception $e) {
            echo "Error adding to cart: " . $e->getMessage() . "\n";
            return false;
        }
    }
    public function getCart(): Cart
    {
        return $this->cart;
    }
    public function getShippableItems(): array
    {
        $shippableItems = [];
        foreach ($this->cart->getItems() as $cartItem) {
            $product = $cartItem->getProduct();
            if ($product->requiresShipping()) {
                // Add each item based on quantity
                for ($i = 0; $i < $cartItem->getQuantity(); $i++) {
                    $shippableItems[] = $product;
                }
            }
        }
        return $shippableItems;
    }
}
