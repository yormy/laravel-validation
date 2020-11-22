<?php declare(strict_types = 1);

namespace Yormy\LaravelValidation\Rules;

use Yormy\LaravelValidation\Rules\Support\Iso3166Alpha2;
use Yormy\LaravelValidation\Rules\Support\Iso3166Alpha3;

/**
 *
 * Class CountryCode
 * @package Modules\Core\Rules
 */
class CountryCode extends Rule
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
            $array = Iso3166Alpha2::$codes;
        }

        if ($this->iso === 3) {
            $array = Iso3166Alpha3::$codes;
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
            $iso = 'Iso3166 Alpha 2';
        }

        if ($this->iso === 3) {
            $iso = 'Iso3166 Alpha 3';
        }

        $message = (string)__(
            $key,
            [
                'attribute' => $this->getAttribute(),
                'iso' => $iso
            ]
        );

        return $message;
    }
}
