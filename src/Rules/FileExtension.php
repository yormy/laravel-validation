<?php

namespace Yormy\LaravelValidation\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class FileExtension implements Rule
{
    /**
     * @var array
     */
    private $extensions;

    /**
     * @var bool
     */
    private $mimeTypePasses;

    /**
     * @var bool
     */
    private $extensionPasses;

    /**
     * FileExtension constructor.
     * @param array $extensions
     */
    public function __construct(array $extensions)
    {
        $this->extensions = $extensions;
    }

    /**
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return false;
//        $mimeTypeValidator = Validator::make(['image' => $value], ['image' => 'mimes:' . $this->getMimeString()]);
//
//        $this->mimeTypePasses = !$mimeTypeValidator->fails();
//        $this->extensionPasses = \in_array($value->getClientOriginalExtension(), $this->extensions, true);
//        return $this->mimeTypePasses && $this->extensionPasses;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "todo invalid";
//        if (!$this->extensionPasses) {
//            return __('Alleen :extensions bestanden zijn toegestaan', ['extensions' => $this->getExtensionMessage()]);
//        }
//        return __('Dit bestand bevat een ongeldige structuur.');
    }

    /**
     * @return string
     */
    private function getMimeString(): string
    {
        return implode(',', $this->extensions);
    }

    /**
     * @return string
     */
    private function getExtensionMessage(): string
    {
        return strtoupper(implode(', ', $this->extensions));
    }
}
