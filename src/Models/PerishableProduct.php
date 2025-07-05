<?php

namespace Src\Models;

use DateTime;
use Src\Interfaces\Shippable;

class PerishableProduct extends Product implements Shippable
{
    private DateTime $expiryDate;
    private float $weight;
    public function __construct(string $name, float $price, int $quantity, DateTime $expiryDate, float $weight)
    {
        parent::__construct($name, $price, $quantity);
        $this->expiryDate = $expiryDate;
        $this->weight = $weight;
    }
    public function isExpired(): bool
    {
        return new DateTime() > $this->expiryDate;
    }
    public function requiresShipping(): bool
    {
        return true;
    }
    public function getWeight(): float
    {
        return $this->weight;
    }
    public function getExpiryDate(): DateTime
    {
        return $this->expiryDate;
    }
}
