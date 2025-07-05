<?php

use Src\Models\Cart;
use Src\Models\Product;
use Src\Models\Customer;
use Src\Services\CartService;
use Src\Services\CheckoutService;
use Src\Services\ShippingService;

class ECommerceSystem
{
    private CartService $cartService;
    private CheckoutService $checkoutService;
    public function __construct()
    {
        $cart = new Cart();
        $this->cartService = new CartService($cart);
        $shippingService = new ShippingService();
        $this->checkoutService = new CheckoutService($this->cartService, $shippingService);
    }
    public function addToCart(Product $product, int $quantity): bool
    {
        return $this->cartService->addToCart($product, $quantity);
    }
    public function checkout(Customer $customer): bool
    {
        return $this->checkoutService->processCheckout($customer);
    }
    public function getCart(): Cart
    {
        return $this->cartService->getCart();
    }
}
