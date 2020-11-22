<?php declare(strict_types = 1);

namespace Yormy\LaravelValidation\Rules;

class IsNull extends Rule
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

        return $value === null;
    }
}
