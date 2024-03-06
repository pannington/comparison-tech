<?php

namespace App\Interfaces;

interface CurrencyInterface
{
    public function getPrefix(): string;
    public function getSeparator(): string;
    public function getSuffix(): string;
    public function getDenominations(): array;
}
