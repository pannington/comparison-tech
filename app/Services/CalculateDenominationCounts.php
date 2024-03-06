<?php

namespace App\Services;

use App\Interfaces\CurrencyInterface;
use ErrorException;

class CalculateDenominationCounts
{

    public function calculateDenominationCounts(int $total_in_lowest_denomination, CurrencyInterface $currencyInterface): array
    {
        $denominations = $currencyInterface->getDenominations();
        $denomination_counts = [];
        $denomination_index = 0;
        $denomination_modular = $total_in_lowest_denomination;

        while ($denomination_modular != 0) {
            $denomination_counts[$denomination_index]['display'] = $denominations[$denomination_index]['display'];

            $current_denomination_amount = $denominations[$denomination_index]['in_lowest_denomination'];
            $denomination_counts[$denomination_index]['in_lowest_denomination'] = $current_denomination_amount;

            $denomination_count = floor($denomination_modular / $current_denomination_amount);
            $denomination_counts[$denomination_index]['count'] = $denomination_count;

            $denomination_modular %= $current_denomination_amount;

            $denomination_index++;
        }

        return $denomination_counts;
    }

    public function lowestDenominationFromTotalNotStrict(string $total_in_lowest_denomination, CurrencyInterface $currencyInterface): int
    {
        $prefix = $currencyInterface->getPrefix();
        $separator = $currencyInterface->getSeparator();
        $suffix = $currencyInterface->getSuffix();

        $has_valid_prefix = false;
        $has_valid_separator = false;
        $has_valid_suffix = false;

        $return = 0;
        $valid_total = false;

        echo $total_in_lowest_denomination . PHP_EOL;

        $test = $total_in_lowest_denomination;
        $test = str_replace([$prefix, $suffix], '', $test);
        echo (float) $test . PHP_EOL;
        // If no separator - check for prefix - If prefix, multiply by 100
        // If no separator - AND no suffix - multiply by 100
        // If prefix AND separator NO suffix - multiply by 100

        if ($total_in_lowest_denomination != $test) {
            echo 'NOT VALID';
        }
    }

    public function lowestDenominationFromTotal(string $total_in_lowest_denomination, CurrencyInterface $currencyInterface): int
    {
        $prefix = $currencyInterface->getPrefix();
        $separator = $currencyInterface->getSeparator();
        $suffix = $currencyInterface->getSuffix();

        $has_valid_prefix = false;
        $has_valid_separator = false;
        $has_valid_suffix = false;

        $return = 0;
        $valid_total = false;

        // Check for only one PREFIX char
        if (substr_count($total_in_lowest_denomination, $prefix) > 1) {
            throw new ErrorException('Invalid $total_in_lowest_denomination - Multiple prefixes found - value [' . $total_in_lowest_denomination . '], prefix [' . $prefix . ']');
        }
        // Check for PREFIX as the start char
        $has_valid_prefix = (substr($total_in_lowest_denomination, 0, strlen($prefix)) === $prefix && substr_count($total_in_lowest_denomination, $prefix) === 1);

        // Check for only one SEPARATOR char
        if (substr_count($total_in_lowest_denomination, $separator) > 1) {
            throw new ErrorException('Invalid $total_in_lowest_denomination - Multiple separators found - value [' . $total_in_lowest_denomination . '], separator [' . $separator . ']');
        }
        // Check for SEPARATOR as a char, not first or last
        $has_valid_separator = (substr_count($total_in_lowest_denomination, $separator, 1, -1) === 1);

        // Check for only one SUFFIX char
        if (substr_count($total_in_lowest_denomination, $suffix) > 1) {
            throw new ErrorException('Invalid $total_in_lowest_denomination - Multiple suffixes found - value [' . $total_in_lowest_denomination . '], suffix [' . $suffix . ']');
        }
        // Check for 'p' as the last char
        $has_valid_suffix = (strtoupper(substr($total_in_lowest_denomination, -1, strlen($suffix))) === strtoupper($suffix) && substr_count($total_in_lowest_denomination, $suffix) === 1);

        $total_in_lowest_denomination = str_replace([$prefix, $separator, $suffix], ['', '', ''], $total_in_lowest_denomination);

        // If prefix, separator and suffix
        if ($has_valid_prefix && $has_valid_separator && $has_valid_suffix) {
            $valid_total = true;
            $return = (int) $total_in_lowest_denomination;
        }
        // If prefix and no separator and NO suffix
        if ($has_valid_prefix && !$has_valid_separator && !$has_valid_suffix) {
            $valid_total = true;
            $return = (int) $total_in_lowest_denomination;
            $return *= 100;
        }
        // If NO prefix and no separator AND suffix
        if (!$has_valid_prefix && !$has_valid_separator && $has_valid_suffix) {
            $valid_total = true;
            $return = (int) $total_in_lowest_denomination;
        }
        // If NO prefix, AND separator and NO suffix
        if (!$has_valid_prefix && $has_valid_separator && $has_valid_suffix) {
            $valid_total = true;
            $return = (int) $total_in_lowest_denomination;
            $return *= 100;
        }
        // If no prefix, separator or suffix, check is a valid int
        if (!$has_valid_prefix && !$has_valid_separator && !$has_valid_suffix && (int) $total_in_lowest_denomination == $total_in_lowest_denomination) {
            $valid_total = true;
            $return = (int) $total_in_lowest_denomination;
        }

        if (!$valid_total) {
            throw new ErrorException('Invalid total given - value [' . $total_in_lowest_denomination . ']');
        }

        return $return;
    }
}
