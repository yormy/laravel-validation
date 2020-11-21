<?php

namespace Modules\Core\Rules;

use Modules\Core\Rules\Rule;

class EvenNumber extends Rule
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

        return (int) $value % 2 === 0;
    }
}
