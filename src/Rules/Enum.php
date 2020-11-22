<?php declare(strict_types = 1);

/*
This rule will validate if the value under validation is part of the given enum class.
We assume that the enum class has a static toArray method that returns all valid values.
If you're looking for a good enum class, take a look at spatie/enum or myclabs/php-enum.

Consider the following enum class:

class UserRole extends MyCLabs\Enum\Enum
{
    const ADMIN = 'admin';
    const REVIEWER = 'reviewer';
}
The Enum rule can be used like this:

// in a `FormRequest`

use Spatie\ValidationRules\Rules\Enum;

public function rules()
{
    return [
        'role' => [new Enum(UserRole::class)],
    ];
}
 */
namespace Yormy\LaravelValidation\Rules;

/**
 * This rule will validate if the value under validation is part of the given enum class.
 * We assume that the enum class has a static toArray method that returns all valid values
 * https://github.com/spatie/laravel-validation-rules
 * Class Enum
 * @package Modules\Core\Rules
 */
class Enum extends Rule
{
    /** @var array */
    protected $validValues;

    public function __construct(string $enumClass)
    {
        $this->validValues = array_keys($enumClass::toArray());
    }

    public function passes($attribute, $value): bool
    {
        $this->setAttribute($attribute);

        return in_array($value, $this->validValues);
    }

    /**
     * @return string
     */
    public function message(): string
    {
        $key = 'core::validation.'.$this->getMessageKey();
        $validValues = implode(', ', $this->validValues);

        $message = (string)__(
            $key,
            [
                'attribute' => $this->getAttribute(),
                'validValues' => $validValues,
            ]
        );

        return $message;
    }
}
