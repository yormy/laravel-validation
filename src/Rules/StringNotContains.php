<?php

namespace Modules\Core\Rules;

use Modules\Core\Rules\Rule;
use Modules\Core\Rules\Exceptions\RuleSetupException;

class StringNotContains extends Rule
{
    protected $phrases = [];

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->setAttribute($attribute);

        if ($this->phrases === []) {
            throw new RuleSetupException('Zero phrases have been whitelisted using the "phrases()" method');
        }

        return preg_match('(' . implode('|', $this->phrases) . ')', $value) === 0;
    }

    /**
     * @param  array  $phrases
     * @return self
     */
    public function phrases(array $phrases): self
    {
        $this->phrases = $phrases;

        return $this;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        $key = 'core::validation.'.$this->getMessageKey();

        return __(
            $key,
            [
                'attribute' => $this->getAttribute(),
                'phrases'   => implode(
                    ', ',
                    array_map(
                        function ($phrases) {
                            return "'".$phrases. "'";
                        },
                        $this->phrases
                    )
                ),
            ]
        );
    }
}
