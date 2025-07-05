<?php

namespace Src\Services;

use Exception;
use Src\Models\Cart;
use Src\Models\Customer;

class CheckoutService
{
    private CartService $cartService;
    private ShippingService $shippingService;
    public function __construct(CartService $cartService, ShippingService $shippingService)
    {
        $this->cartService = $cartService;
        $this->shippingService = $shippingService;
    }
    public function processCheckout(Customer $customer): bool
    {
        try {
            $cart = $this->cartService->getCart();

            $this->validateCheckout($cart, $customer);

            $subtotal = $cart->getSubtotal();
            $shippingFee = $this->calculateShippingFee();
            $totalAmount = $subtotal + $shippingFee;

            if (!$customer->hasEnoughBalance($totalAmount)) {
                throw new Exception("Insufficient balance");
            }

            $customer->deductBalance($totalAmount);

            $this->updateProductQuantities($cart);

            $this->printCheckoutDetails($subtotal, $shippingFee, $totalAmount, $customer->getBalance());

            $this->processShipping();

            $cart->clear();

            return true;
        } catch (Exception $e) {
            echo "Checkout failed: " . $e->getMessage() . "\n\n";
            return false;
        }
    }
    private function validateCheckout(Cart $cart, Customer $customer): void
    {
        if ($cart->isEmpty()) {
            throw new Exception("Cart is empty");
        }

        foreach ($cart->getItems() as $cartItem) {
            $product = $cartItem->getProduct();
            $quantity = $cartItem->getQuantity();

            if (!$product->isInStock($quantity)) {
                throw new Exception("Product out of stock: {$product->getName()}");
            }

            if ($product->isExpired()) {
                throw new Exception("Product expired: {$product->getName()}");
            }
        }
    }
    private function calculateShippingFee(): float
    {
        $shippableItems = $this->cartService->getShippableItems();
        return $this->shippingService->calculateShippingFee($shippableItems);
    }
    private function updateProductQuantities(Cart $cart): void
    {
        foreach ($cart->getItems() as $cartItem) {
            $product = $cartItem->getProduct();
            $quantity = $cartItem->getQuantity();
            $product->reduceQuantity($quantity);
        }
    }
    private function processShipping(): void
    {
        $shippableItems = $this->cartService->getShippableItems();
        if (!empty($shippableItems)) {
            $this->shippingService->shipItems($shippableItems);
        }
    }
    private function printCheckoutDetails(float $subtotal, float $shippingFee, float $totalAmount, float $remainingBalance): void
    {
        echo "=== CHECKOUT DETAILS ===\n";
        echo "Order Subtotal: $" . number_format($subtotal, 2) . "\n";
        echo "Shipping Fees: $" . number_format($shippingFee, 2) . "\n";
        echo "Paid Amount: $" . number_format($totalAmount, 2) . "\n";
        echo "Customer Balance After Payment: $" . number_format($remainingBalance, 2) . "\n";
        echo "========================\n\n";
    }
}
