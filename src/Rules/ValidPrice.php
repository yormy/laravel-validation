<?php

namespace Modules\Core\Rules;

use Modules\Core\Rules\Rule;

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
