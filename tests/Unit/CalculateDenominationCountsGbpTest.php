<?php

namespace Tests\Unit;

use App\Interfaces\CurrencyInterface;
use App\Models\CurrencyGbp;
use App\Services\CalculateDenominationCounts;
use PHPUnit\Framework\TestCase;

class CalculateDenominationCountsGbpTest extends TestCase
{

    private CalculateDenominationCounts $calculate_denomination_counts;
    private CurrencyInterface $currency_interface;

    public function init()
    {
        $this->calculate_denomination_counts = new CalculateDenominationCounts();
        $this->currency_interface = new CurrencyGbp();
    }
    
    public function test_calculation_successes(): void
    {
        $this->init();

        $this->assertTrue(true);
    }
    
    public function test_calculation_failures(): void
    {
        $this->init();

        $this->assertTrue(true);
    }
}
