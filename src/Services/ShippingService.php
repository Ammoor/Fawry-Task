<?php

namespace Src\Services;

use Src\Interfaces\Shippable;

class ShippingService
{
    private const SHIPPING_RATE_PER_KG = 5.0;
    public function calculateShippingFee(array $shippableItems): float
    {
        $totalWeight = 0;
        foreach ($shippableItems as $item) {
            if ($item instanceof Shippable) {
                $totalWeight += $item->getWeight();
            }
        }
        return $totalWeight * self::SHIPPING_RATE_PER_KG;
    }
    public function shipItems(array $shippableItems): void
    {
        echo "Shipping Service - Processing shipment:\n";
        foreach ($shippableItems as $item) {
            if ($item instanceof Shippable) {
                echo "- {$item->getName()} (Weight: {$item->getWeight()}kg)\n";
            }
        }
        echo "Items shipped successfully!\n\n";
    }
}
