<?php declare(strict_types=1);

namespace Modules\Core\Rules;

use Modules\Core\Rules\Rule;
use Modules\Core\Rules\Exceptions\RuleSetupException;

use Illuminate\Support\Str;

use function __;
use function array_map;
use function collect;
use function implode;
use function sprintf;

/**
 * - Contains any : new StringContains())->phrases(['laravel','php',])
 * - Contains all : new StringContains())->phrases(['laravel','php',])->strictly()
 * Class StringContains
 * @package Modules\Core\Rules
 */
class StringContains extends Rule
{
    /** @var array */
    protected $phrases = [];

    /** @var bool */
    protected $mustContainAllPhrases = false;

    /**
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $this->setAttribute($attribute);

        if ($this->phrases === []) {
            throw new RuleSetupException('Zero phrases have been whitelisted using the "phrases()" method');
        }

        $matched = collect($this->phrases)->reject(
            function ($phrase) use ($value) {
                return ! Str::contains($value, $phrase);
            }
        );

        if ($this->mustContainAllPhrases) {
            return Str::containsAll($value, $this->phrases);
        }

        return $matched->isNotEmpty();
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
     * @return $this
     */
    public function strictly(): self
    {
        $this->mustContainAllPhrases = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function loosely(): self
    {
        $this->mustContainAllPhrases = false;

        return $this;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        $key = sprintf(
            'core::validation.%s.%s',
            $this->getMessageKey(),
            $this->mustContainAllPhrases ? 'strict' : 'loose'
        );

        return __(
            $key,
            [
                'attribute' => $this->getAttribute(),
                'phrases'   => implode(
                    ', ',
                    array_map(
                        function ($phrase) {
                            return "'".$phrase. "'";
                        },
                        $this->phrases
                    )
                ),
            ]
        );
    }
}
