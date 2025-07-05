<?php

use Src\Models\Customer;
use Src\Models\DigitalProduct;
use Src\Models\ShippableProduct;
use Src\Models\PerishableProduct;

require_once __DIR__ . '/vendor/autoload.php';

echo "=== MODULAR E-COMMERCE SYSTEM DEMO ===\n\n";

// Create products
$cheese = new PerishableProduct("Cheese", 8.99, 10, new DateTime('+7 days'), 0.5);
$biscuits = new PerishableProduct("Biscuits", 3.50, 15, new DateTime('+30 days'), 0.2);
$tv = new ShippableProduct("TV", 499.99, 5, 15.0);
$mobile = new ShippableProduct("Mobile", 299.99, 20, 0.3);
$mobileCard = new DigitalProduct("Mobile Scratch Card", 10.00, 100);

// Create customer
$customer = new Customer("John Doe", 1000.00);

// Create e-commerce system
$ecommerce = new ECommerceSystem();

// Add products to cart
echo "Adding products to cart...\n";
$ecommerce->addToCart($cheese, 2);
$ecommerce->addToCart($biscuits, 3);
$ecommerce->addToCart($tv, 1);
$ecommerce->addToCart($mobileCard, 5);

echo "Cart contents:\n";
foreach ($ecommerce->getCart()->getItems() as $item) {
    echo "- {$item->getProduct()->getName()}: {$item->getQuantity()} x $" .
        number_format($item->getProduct()->getPrice(), 2) .
        " = $" . number_format($item->getSubtotal(), 2) . "\n";
}
echo "\n";

// Process checkout
echo "Processing checkout...\n";
$ecommerce->checkout($customer);

// Test error scenarios
echo "=== ERROR SCENARIOS ===\n\n";

// Empty cart
echo "Attempting checkout with empty cart...\n";
$ecommerce->checkout($customer);

// Insufficient balance
echo "Adding expensive items and trying checkout with insufficient balance...\n";
$ecommerce->addToCart($tv, 3);
$ecommerce->checkout($customer);

// Expired product
echo "Trying to add expired product...\n";
$expiredCheese = new PerishableProduct("Expired Cheese", 5.99, 5, new DateTime('-1 day'), 0.5);
$ecommerce->addToCart($expiredCheese, 1);

// Insufficient stock
echo "Trying to add more quantity than available...\n";
$ecommerce->addToCart($tv, 10);

echo "Demo completed!\n";
