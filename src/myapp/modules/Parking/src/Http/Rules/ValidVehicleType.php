<?php

namespace Roofr\Parking\Http\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use Roofr\Parking\Enums\VehicleTypes;

class ValidVehicleType implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!in_array(strtolower(trim($value)), VehicleTypes::getValues())) {
            $fail(new PotentiallyTranslatedString('The :attribute must be a valid vehicle type.'));
        }
    }
}
