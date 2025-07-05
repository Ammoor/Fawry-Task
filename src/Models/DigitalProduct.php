<?php

namespace Src\Models;

class DigitalProduct extends Product
{
    public function __construct(string $name, float $price, int $quantity)
    {
        parent::__construct($name, $price, $quantity);
    }
    public function isExpired(): bool
    {
        return false;
    }
    public function requiresShipping(): bool
    {
        return false;
    }
}
