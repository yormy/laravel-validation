<?php declare(strict_types=1);

namespace Yormy\LaravelValidation\Rules;

use Illuminate\Support\Facades\Hash;

class CurrentPasswordConfirmed extends Rule
{
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function passes($attribute, $value): bool
    {
        $this->setAttribute($attribute);

        if (Hash::check($attribute, $this->user->password)) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        //$key = 'core::validation.unique';
        $key = 'validation.current_password';

        $message = (string)__(
            $key,
            [
                'attribute' => $this->getAttribute(),
            ]
        );

        return $message;
    }
}
