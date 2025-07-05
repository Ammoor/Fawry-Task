<?php

namespace Src\Models;

abstract class Product
{
    protected string $name;
    protected float $price;
    protected int $quantity;
    public function __construct(string $name, float $price, int $quantity)
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getPrice(): float
    {
        return $this->price;
    }
    public function getQuantity(): int
    {
        return $this->quantity;
    }
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
    public function reduceQuantity(int $amount): void
    {
        $this->quantity -= $amount;
    }
    public function isInStock(int $requestedQuantity): bool
    {
        return $this->quantity >= $requestedQuantity;
    }
    abstract public function isExpired(): bool;
    abstract public function requiresShipping(): bool;
}
