<?php

namespace Src\Models;

class Customer
{
    private string $name;
    private float $balance;
    public function __construct(string $name, float $balance)
    {
        $this->name = $name;
        $this->balance = $balance;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getBalance(): float
    {
        return $this->balance;
    }
    public function deductBalance(float $amount): void
    {
        $this->balance -= $amount;
    }
    public function hasEnoughBalance(float $amount): bool
    {
        return $this->balance >= $amount;
    }
}
