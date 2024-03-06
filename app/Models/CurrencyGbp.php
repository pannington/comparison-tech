<?php

namespace App\Models;

use App\Interfaces\CurrencyInterface;

class CurrencyGbp implements CurrencyInterface
{
    public function getPrefix(): string
    {
        return '£';
    }

    public function getSeparator(): string
    {
        return '.';
    }

    public function getSuffix(): string
    {
        return 'p';
    }

    public function getDenominations(): array
    {
        return [
            ['display' => '£2', 'in_lowest_denomination' => 200],
            ['display' => '£1', 'in_lowest_denomination' => 100],
            ['display' => '50p', 'in_lowest_denomination' => 50],
            ['display' => '20p', 'in_lowest_denomination' => 20],
            ['display' => '10p', 'in_lowest_denomination' => 10],
            ['display' => '5p', 'in_lowest_denomination' => 5],
            ['display' => '2p', 'in_lowest_denomination' => 2],
            ['display' => '1p', 'in_lowest_denomination' => 1]
        ];
    }
}
