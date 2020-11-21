<?php declare(strict_types=1);

namespace Yormy\LaravelValidation\Rules;

use Modules\Core\Rules\Rule;

use function is_string;
use function mb_strtolower;

class Lowercase extends Rule
{
    /**
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $this->setAttribute($attribute);

        if (! is_string($value)) {
            return false;
        }

        return mb_strtolower($value, 'UTF-8') === (string) $value;
    }
}
