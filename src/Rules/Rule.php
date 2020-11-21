<?php declare(strict_types=1);

namespace Modules\Core\Rules;

use function __;
use function class_basename;
use function get_called_class;
use Illuminate\Contracts\Validation\Rule as BaseRule;
use Illuminate\Support\Str;

abstract class Rule implements BaseRule
{
    /** @var string */
    protected $attribute;

    /**
     * @return string
     */
    public function message(): string
    {
        return __(
            'core::validation.'.$this->getMessageKey(),
            [
                'attribute' => $this->getAttribute(),
            ]
        );
    }

    /**
     * @return string
     */
    public function getAttribute(): string
    {
        return $this->attribute;
    }

    /**
     * @param  string  $attribute
     */
    public function setAttribute(string $attribute): void
    {
        $this->attribute = $attribute;
    }

    /**
     * @return string
     */
    public function getMessageKey(): string
    {
        $calledClassName = class_basename(get_called_class());

        return Str::slug(Str::snake($calledClassName));
    }
}
