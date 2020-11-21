<?php

namespace Modules\Core\Rules;

/**
 * Allow only Alpha (including umlaut Ü etc and special chars) , dashes whitespace
 * Class AlphaDashWhitespace
 * @package Modules\Core\Rules
 */
class NameWithSymbols extends Rule
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

        if (! is_string($value) && ! is_numeric($value)) {
            return false;
        }

        return preg_match('/^[\s\pL\pM\pN-!#@$%^&*()_+|~=`{}\[\]\\:";\'<>?,.\/]+$/u', $value) > 0;
    }
}
