<?php declare(strict_types = 1);

namespace Yormy\LaravelValidation\Rules;

use function __;
use function class_basename;
use function get_called_class;
use Illuminate\Contracts\Validation\Rule as BaseRule;
use Illuminate\Support\Str;

abstract class Rule implements BaseRule
{
    /** @var string */
    protected $attribute;

    public function message(): string
    {
        return (string)__('bedrock-core::validation.' . $this->getMessageKey(), ['attribute' => $this->getAttribute()]);
    }

    public function getAttribute(): string
    {
        return $this->attribute;
    }

    public function setAttribute(string $attribute): void
    {
        $this->attribute = $attribute;
    }

    public function getMessageKey(): string
    {
        $calledClassName = class_basename(get_called_class());

        return Str::slug(Str::snake($calledClassName));
    }
}
