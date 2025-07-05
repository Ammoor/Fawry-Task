<?php

namespace Src\Interfaces;

interface Shippable
{
    public function getName(): string;
    public function getWeight(): float;
}
