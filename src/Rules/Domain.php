<?php declare(strict_types=1);

namespace Modules\Core\Rules;

class Domain extends Rule
{
    /**
     * Determine if the validation rule passes.
     *
     **/
    public function passes($attribute, $value) : bool
    {
        $this->setAttribute($attribute);

        return preg_match('/^([\w-]+\.)*[\w\-]+\.\w{2,10}$/', $value) > 0;
    }
}
