<?php declare(strict_types=1);

namespace Yormy\LaravelValidation\Rules;

class EncryptedUnique extends Rule
{
    private string $modelClass;
    private string $fieldName;

    public function __construct(string $modelClass, string $fieldName)
    {
        $this->modelClass = $modelClass;
        $this->fieldName = $fieldName;
    }

    public function passes($attribute, $value): bool
    {
        $this->setAttribute($attribute);

        $existingModel = (new $this->modelClass)->whereEncrypted($this->fieldName, $value)->first();
        if ($existingModel) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        //$key = 'core::validation.unique';
        $key = 'validation.unique';

        $message = (string)__(
            $key,
            [
                'attribute' => $this->getAttribute(),
            ]
        );

        return $message;
    }
}
