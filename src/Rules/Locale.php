<?php declare(strict_types = 1);

namespace Yormy\LaravelValidation\Rules;

class Locale extends Rule
{

    /**
     * Generate an example value that satisifies the validation rule.
     *
     **/
    public function example() : string
    {
        $allowedLocales =  array_keys(config('laravellocalization.supportedLocales'));
        return implode(',', $allowedLocales);
    }



    /**
     * Determine if the validation rule passes.
     **/
    public function passes($attribute, $value) : bool
    {
        $this->setAttribute($attribute);

        $allowedLocales = array_keys(config('laravellocalization.supportedLocales'));
        if (in_array($value, $allowedLocales)) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        $key = 'core::validation.'.$this->getMessageKey();

        $message = (string)__(
            $key,
            [
                'attribute' => $this->getAttribute(),
                'example' => $this->example()
            ]
        );

        return $message;
    }
}
