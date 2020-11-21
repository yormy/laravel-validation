<?php declare(strict_types=1);

namespace Yormy\LaravelValidation\Rules;

use Modules\Core\Rules\Rule;
use Modules\Core\Rules\Exceptions\RuleSetupException;
use Modules\Core\Rules\StringContains;

class MaxWords extends Rule
{
    private $maxWords = null;

    /**
     * Determine if the validation rule passes.
     *
     **/
    public function passes($attribute, $value) : bool
    {
        $this->setAttribute($attribute);

        if ($this->maxWords === null || $this->maxWords === 0) {
            throw new RuleSetupException('use ->max() to specify the number of words to allow');
        }

        return count(preg_split('~[^\p{L}\p{N}\']+~u', $value)) <= $this->maxWords;
    }

    public function max(int $maxWords): self
    {
        $this->maxWords = $maxWords;

        return $this;
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
                'max' => $this->maxWords
            ]
        );

        return $message;
    }
}
