<?php

namespace Roofr\Parking\Http\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use Carbon\Carbon;

class MinimumParkingTimeInterval implements ValidationRule
{
    private string $startTime;

    public function __construct(string $startTime)
    {
        $this->startTime = $startTime;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $startTime = Carbon::createFromFormat('Y-m-d H:i:s', $this->startTime);
        $endTime = Carbon::createFromFormat('Y-m-d H:i:s', $value);

        if ($startTime->diffInMinutes($endTime) < 30) {
            $fail(new PotentiallyTranslatedString('The :attribute must be at least 30 minutes after the start time.'));
        }
    }
}
