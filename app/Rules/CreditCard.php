<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CreditCard implements ValidationRule
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
    public function passes($attribute, $value)
    {
        // Remove spaces from the card number
        $cleanedValue = str_replace(' ', '', $value);

        // Validate the card number using the Luhn algorithm
        $sum = 0;
        $length = strlen($cleanedValue);
        $parity = $length % 2;

        for ($i = 0; $i < $length; $i++) {
            $digit = (int)$cleanedValue[$i];

            if ($i % 2 === $parity) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }

            $sum += $digit;
        }

        return $sum % 10 === 0;
    }

    public function message()
    {
        return 'The :attribute is not a valid credit card number.';
    }
}
