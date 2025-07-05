<?php

namespace Src\Models;

use Src\Interfaces\Shippable;

class ShippableProduct extends Product implements Shippable
{
    private float $weight;
    public function __construct(string $name, float $price, int $quantity, float $weight)
    {
        parent::__construct($name, $price, $quantity);
        $this->weight = $weight;
    }
    public function isExpired(): bool
    {
        return false;
    }
    public function requiresShipping(): bool
    {
        return true;
    }
    public function getWeight(): float
    {
        return $this->weight;
    }
}
