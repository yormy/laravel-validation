<?php declare(strict_types=1);

namespace Modules\Core\Rules;

use Modules\Core\Rules\Rule;

use Modules\Core\Rules\Support\Iso3166Alpha2;
use Modules\Core\Rules\Support\Iso3166Alpha3;

class CitizenIdentification extends Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * The rule requires one parameter:
     * 1. The identification type to use ('USA' or 'US, 'GBR' or 'GB', 'FRA' or 'FR', 'BRA' or 'BR').
     *
     **/
    public function passes($attribute, $value) : bool
    {
        $this->setAttribute($attribute);

        $array = ($this->parameters[0] ?? 2) === 2 ? Iso3166Alpha2::$codes : Iso3166Alpha3::$codes;

        switch (mb_strtoupper($this->parameters[0] ?? 'USA')) {
            case 'US':
            case 'USA':
                return $this->verifyUnitedStates($value);

            case 'GB':
            case 'GBR':
                return $this->verifyUnitedKingdom($value);

            case 'FR':
            case 'FRA':
                return $this->verifyFrance($value);

            case 'BR':
            case 'BRA':
                return $this->verifyBrazil($value);

            default:
                return false;
        }
    }





    /**
     * Verify whether the given value is a valid French citizen number.
     *
     **/
    protected function verifyFrance($value) : bool
    {
        return preg_match(
            '/^[1,2][ ]?[0-9]{2}[ ]?[0,1,2,3,5][0-9][ ]?[0-9A-Z]{5}[ ]?[0-9]{3}[ ]?[0-9]{2}$/',
            $value
        ) > 0;
    }



    /**
     * Verify whether the given value is a valid United Kingdom citizen number.
     *
     **/
    protected function verifyUnitedKingdom($value) : bool
    {
        return preg_match('/^[A-CEGHJ-PR-TW-Z]{1}[A-CEGHJ-NPR-TW-Z]{1}[0-9]{6}[A-DFM]{0,1}$/', $value) > 0;
    }



    /**
     * Verify whether the given value is a valid United States citizen number.
     *
     **/
    protected function verifyUnitedStates($value) : bool
    {
        return preg_match('/^(?!000|666)[0-8][0-9]{2}-(?!00)[0-9]{2}-(?!0000)[0-9]{4}$/', $value) > 0;
    }



    /**
     * Verify whether the given value is a valid Brazil citizen number.
     *
     **/
    protected function verifyBrazil($value) : bool
    {
        $value = preg_replace('/[^0-9]/is', '', $value);

        if (strlen($value) !== 11 || preg_match('/(\d)\1{10}/', $value)) {
            return false;
        }

        for ($t = 9; $t < 11; $t+=1) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $value[$c] * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($value[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        $key = 'core::validation.'.$this->getMessageKey();

        $message = __(
            $key,
            [
                'attribute' => $this->getAttribute(),
                'example' => $this->example()
            ]
        );

        return $message;
    }
}
