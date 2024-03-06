<?php

namespace App\Models;

use ErrorException;
use Illuminate\Database\Eloquent\Model;

class Denomination extends Model
{
    private string $display;
    private int $in_lowest_denomination;
    private int $count = 0;

    public function __construct(string $display, int $in_lowest_denomination)
    {
        if ($display && !is_string($display)) {
            throw new ErrorException("Display must be of type string, value given '" . $display . "'");
        }
        $this->display = $display;

        if (!is_int($in_lowest_denomination) && $in_lowest_denomination !== 0) {
            throw new ErrorException("Lowest Denomination must be of type int with a positive value, value given '" . $in_lowest_denomination . "'");
        }
        $this->in_lowest_denomination = $in_lowest_denomination;
    }

    public function getDisplay(): string
    {
        return $this->display;
    }

    public function getInLowestDenomination(): int
    {
        return $this->in_lowest_denomination;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function setCount(int $count): void
    {
        $this->count = $count;
    }
}
