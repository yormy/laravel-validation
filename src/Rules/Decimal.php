<?php declare(strict_types = 1);

namespace Yormy\LaravelValidation\Rules;

/**
 * - (new Decimal())->integer(3)->fractal(2);
 * Class Decimal
 * @package Modules\Core\Rules
 */
class Decimal extends Rule
{

    private $integer=5;

    private $fractal=2;

    /**
     * Generate an example value that satisifies the validation rule.
     *
     **/
    public function example() : string
    {
        return mt_rand(1, (int) str_repeat('9', $this->integer)) . '.' .
               mt_rand(1, (int) str_repeat('9', $this->fractal));
    }



    /**
     * Determine if the validation rule passes.
     *
     * The rule has two parameters:
     * 1. The maximum number of digits before the decimal point.
     * 2. The maximum number of digits after the decimal point.
     *
     **/
    public function passes($attribute, $value) : bool
    {
        $this->setAttribute($attribute);

        return preg_match(
            "/^[0-9]{1,{$this->integer}}(\.[0-9]{1,{$this->fractal}})$/",
            $value
        ) > 0;
    }

    /**
     * @param  array  $phrases
     * @return self
     */
    public function integer(int $integer): self
    {
        $this->integer = $integer;

        return $this;
    }

    /**
     * @param  array  $phrases
     * @return self
     */
    public function fractal(int $fractal): self
    {
        $this->fractal = $fractal;

        return $this;
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
