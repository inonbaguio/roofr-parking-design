<?php

namespace Roofr\Parking\Http\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FutureTimeRule implements ValidationRule
{
    public function validate($attribute, $value, Closure $fail): void
    {
        $time = Carbon::createFromFormat('Y-m-d H:i:s', $value);
        $now = Carbon::now();

        if (!$time->greaterThanOrEqualTo($now->addMinutes(30))) {
            $fail('The :attribute must be at least 30 minutes in the future.');
        }
    }
}
