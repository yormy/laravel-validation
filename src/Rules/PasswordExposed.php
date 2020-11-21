<?php declare(strict_types=1);

namespace Yormy\LaravelValidation\Rules;

use Modules\Core\Rules\Rule;

use Modules\Core\Rules\Factories\PasswordExposedCheckerFactory;
use DivineOmega\PasswordExposed\Enums\PasswordStatus;
use DivineOmega\PasswordExposed\PasswordExposedChecker;

/**
 * Check if password is exposed and listed in HaveIBeenPowned
 * Class PasswordExposed
 * @package Modules\Core\Rules
 */
class PasswordExposed extends Rule
{
    /**
     * @var PasswordExposedChecker
     */
    private $passwordExposedChecker;
    /**
     * @var string
     */
    private $message = 'The :attribute has been exposed in a data breach.';

    /**
     * PasswordExposed constructor.
     *
     * @param PasswordExposedChecker|null $passwordExposedChecker
     */
    public function __construct(PasswordExposedChecker $passwordExposedChecker = null)
    {
        if (!$passwordExposedChecker) {
            $factory = new PasswordExposedCheckerFactory();
            $passwordExposedChecker = $factory->instance();
        }

        $this->passwordExposedChecker = $passwordExposedChecker;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->setAttribute($attribute);

        $passwordStatus = $this->passwordExposedChecker->passwordExposed($value);

        return $passwordStatus !== PasswordStatus::EXPOSED;
    }
}
