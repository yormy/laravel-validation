<?php declare(strict_types = 1);

namespace Yormy\LaravelValidation\Rules;

use function strip_tags;

class ExcludesHtml extends Rule
{
    /**
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $this->setAttribute($attribute);

        return strip_tags((string) $value) === $value;
    }
}
