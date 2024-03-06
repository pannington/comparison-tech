<?php

namespace App\Http\Controllers;

use App\Services\CalculateDenominationCounts;
use App\Models\CurrencyGbp;
use ErrorException;
use Illuminate\Http\Request;

class CalculateController extends Controller
{

    public function __construct()
    {
    }

    public function get(Request $request)
    {
        return view('calculate', ['denomination_counts' => [], 'show_zero_counts' => false, 'total' => 0]);
    }

    public function posts(Request $request)
    {
        try {
            $total = $request->input('total') ?? 0;

            $currency = new CurrencyGbp();
            $calucluateDenominationCounts = new CalculateDenominationCounts();

            $total_in_lowest_denomination = $calucluateDenominationCounts->lowestDenominationFromTotal($total, $currency);

            $denomination_counts = $calucluateDenominationCounts->calculateDenominationCounts($total_in_lowest_denomination, $currency);

            return view('calculate', ['denomination_counts' => $denomination_counts, 'total' => $total]);

        } catch (ErrorException $e) {
            return view('calculate', ['error' => $e, 'denomination_counts' => [], 'total' => 0]);
        }
    }
}
