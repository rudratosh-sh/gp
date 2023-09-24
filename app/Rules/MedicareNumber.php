<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MedicareNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Remove any spaces from the value
        $value = str_replace(' ', '', $value);

        // Check if the length is exactly 11 characters
        if (strlen($value) !== 11) {
            return false;
        }

        // Check if the first digit is in the range 2-6
        $firstDigit = (int) $value[0];
        if ($firstDigit < 2 || $firstDigit > 6) {
            return false;
        }

        // Calculate the checksum
        $checksum = 0;
        for ($i = 0; $i < 8; $i++) {
            $digit = (int) $value[$i];
            $weight = ($i % 2 === 0) ? [1, 3, 7, 9][$i] : 1;
            $checksum += $digit * $weight;
        }

        // Check if the checksum matches the ninth digit
        if (($checksum % 10) !== (int) $value[8]) {
            return false;
        }

        return true; // The value is valid
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is not a valid Medicare number.';
    }
}
