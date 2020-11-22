<?php declare(strict_types = 1);

namespace Yormy\LaravelValidation\Rules;

class ValidPrice extends Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->setAttribute($attribute);

        $regex = '/^[\d]+[\.][\d]{2}$/';

        return preg_match($regex, $value) > 0;
    }
}
