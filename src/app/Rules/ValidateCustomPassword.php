<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateCustomPassword implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
		$countErrors = 0;
        $msg = 'La contraseña debe contener ';
        if (!preg_match("/[A-Z]/", $value)) {
			$countErrors += 1; 
			$msg = $msg.'al menos una letra mayúscula';
        }
        if (!preg_match("/[0-9]/", $value)) {
			$msg = $msg.($countErrors > 0 ? ', al menos un número' : 'al menos un número');
        }
        if (!preg_match("/[\W]/", $value)) {
			$msg = $msg.($countErrors > 0 ? ', al menos un caracter especial' : 'al menos un caracter especial');
			$countErrors += 1; 
        }
		if ($countErrors > 0) {
			$fail($msg);
		}
    }
}