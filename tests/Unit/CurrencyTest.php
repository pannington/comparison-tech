<?php

namespace Tests\Unit;

use App\Interfaces\CurrencyInterface;
use App\Models\CurrencyGbp;
use App\Services\CalculateDenominationCounts;
use PHPUnit\Framework\TestCase;
use ErrorException;

class CurrencyTest extends TestCase
{

    private CalculateDenominationCounts $calculate_denomination_counts;
    private CurrencyInterface $currency_interface;

    public function init()
    {
        $this->calculate_denomination_counts = new CalculateDenominationCounts();
        $this->currency_interface = new CurrencyGbp();
    }
    
    public function test_input_successes(): void
    {
        $this->init();

        $this->assertTrue(true);

        // Single Digit
        $this->assertEquals('4', $this->calculate_denomination_counts->lowestDenominationFromTotal('4', $this->currency_interface));
        // Double Digit
        $this->assertEquals('85', $this->calculate_denomination_counts->lowestDenominationFromTotal('85', $this->currency_interface));
        // Triple Digit with suffix
        $this->assertEquals('197p', $this->calculate_denomination_counts->lowestDenominationFromTotal('197', $this->currency_interface));
        // Single Digit with suffix
        $this->assertEquals('2p', $this->calculate_denomination_counts->lowestDenominationFromTotal('2', $this->currency_interface));
        // Triple Digit with separator
        $this->assertEquals('1.87', $this->calculate_denomination_counts->lowestDenominationFromTotal('187', $this->currency_interface));
        // Triple Digit with prefix and separator
        $this->assertEquals('£1.23', $this->calculate_denomination_counts->lowestDenominationFromTotal('123', $this->currency_interface));
        // Single Digit with prefix
        $this->assertEquals('£2', $this->calculate_denomination_counts->lowestDenominationFromTotal('200', $this->currency_interface));
        // Double Digit with prefix
        $this->assertEquals('£10', $this->calculate_denomination_counts->lowestDenominationFromTotal('1000', $this->currency_interface));
        // Double Digit with prefix, separator and suffix
        $this->assertEquals('£1.87p', $this->calculate_denomination_counts->lowestDenominationFromTotal('187', $this->currency_interface));
        // Single Digit with prefix and suffix
        $this->assertEquals('£1p', $this->calculate_denomination_counts->lowestDenominationFromTotal('100', $this->currency_interface)); // This should fail imo.
        // Single Digit with prefix, separator and suffix
        $this->assertEquals('£1.p', $this->calculate_denomination_counts->lowestDenominationFromTotal('100', $this->currency_interface)); // This should fail imo.
        // Leading zero, separator and suffix
        $this->assertEquals('001.41p', $this->calculate_denomination_counts->lowestDenominationFromTotal('141', $this->currency_interface));
        // Excess characters after separator, with suffix
        $this->assertEquals('4.235p', $this->calculate_denomination_counts->lowestDenominationFromTotal('424', $this->currency_interface)); // This should fail imo.
        // Excess characters after separator, with prefix and suffix
        $this->assertEquals('£1.257422457p', $this->calculate_denomination_counts->lowestDenominationFromTotal('126', $this->currency_interface)); // This should fail imo.
    }
    
    public function test_input_failures(): void
    {
        $this->init();

        $this->assertTrue(true);

        // Empty String
        $this->expectException(ErrorException::class);
        $this->calculate_denomination_counts->lowestDenominationFromTotal('', $this->currency_interface);

        // Non Numeric
        $this->expectException(ErrorException::class);
        $this->calculate_denomination_counts->lowestDenominationFromTotal('1x', $this->currency_interface);

        // Non Numeric
        $this->expectException(ErrorException::class);
        $this->calculate_denomination_counts->lowestDenominationFromTotal('£1x.0p', $this->currency_interface);

        // No Valid Input
        $this->expectException(ErrorException::class);
        $this->calculate_denomination_counts->lowestDenominationFromTotal('£p', $this->currency_interface);
    }
}
