<?php declare(strict_types = 1);

namespace Yormy\LaravelValidation\Rules;

use function __;
use Illuminate\Support\Str;
use function preg_match;

/**
 * - new HexColourCode() :  validate a short length code with the prefix i.e. #fff:
 * - (new HexColourCode())->withoutPrefix()->longFormat() : long length code , omitting prefix i.e. cc0000:
 *
 * Class HexColourCode
 * @package Modules\Core\Rules
 */
class HexColorCode extends Rule
{
    /** @var bool */
    protected $forceSixDigitCode = false;

    /** @var bool */
    protected $includePrefix = true;

    /**
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $this->setAttribute($attribute);

        if ($this->includePrefix && ! Str::startsWith($value, '#')) {
            return false;
        }

        $pattern = $this->forceSixDigitCode
            ? '/^#([a-fA-F0-9]{6})$/'
            : '/^#([a-fA-F0-9]{3})$/';

        return (bool) preg_match($pattern, $value);
    }

    /**
     * @return $this
     */
    public function longFormat(): self
    {
        $this->forceSixDigitCode = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function shortFormat(): self
    {
        $this->forceSixDigitCode = false;

        return $this;
    }

    /**
     * @return $this
     */
    public function withPrefix(): self
    {
        $this->includePrefix = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function withoutPrefix(): self
    {
        $this->includePrefix = false;

        return $this;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        $key = 'core::validation.'.$this->getMessageKey();

        $message = (string)__(
            $key.'.base',
            [
                'attribute' => $this->getAttribute(),
                'length' => $this->forceSixDigitCode ? 6 : 3,
            ]
        );

        if ($this->includePrefix) {
            return $message. "; ". __($key.'.prefix');
        }

        return $message;
    }
}
