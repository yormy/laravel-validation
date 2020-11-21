<?php declare(strict_types=1);

namespace Yormy\LaravelValidation\Rules;

use Modules\Core\Rules\Rule;

use Modules\Core\Rules\Support\Iso6391Alpha2;
use Modules\Core\Rules\Support\Iso6391Alpha3;

class LanguageCode extends Rule
{

    private $iso = 2;

    /**
     * Determine if the validation rule passes.
     *
     **/
    public function passes($attribute, $value) : bool
    {
        $this->setAttribute($attribute);

        if ($this->iso === 2) {
            $array = Iso6391Alpha2::$codes;
        }

        if ($this->iso === 3) {
            $array = Iso6391Alpha3::$codes;
        }

        return array_key_exists(strtoupper($value), $array);
    }

    /**
     * @param  array  $phrases
     * @return self
     */
    public function iso3(): self
    {
        $this->iso = 3;

        return $this;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        $key = 'core::validation.'.$this->getMessageKey();

        if ($this->iso === 2) {
            $iso = 'Iso6391 Alpha 2';
        }

        if ($this->iso === 3) {
            $iso = 'Iso6391 Alpha 3';
        }

        $message = __(
            $key,
            [
                'attribute' => $this->getAttribute(),
                'iso' => $iso
            ]
        );

        return $message;
    }
}
