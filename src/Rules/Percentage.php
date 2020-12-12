<?php declare(strict_types = 1);

namespace Yormy\LaravelValidation\Rules;

class Percentage extends Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->setAttribute($attribute);

        if (! is_numeric($value)) {
            return false;
        }

        $intValue = (int)$value;

        return $intValue >= 0 && $intValue <= 100;
    }
}
