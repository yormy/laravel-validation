<?php declare(strict_types = 1);

namespace Yormy\LaravelValidation\Rules;

use Illuminate\Support\Facades\DB;
use Yormy\LaravelValidation\Observers\Events\TarpitTriggerEvent;

class XidWithTrashed extends Rule
{
    private $showField;
    private $table;
    private $errorPrefix;

    public function __construct(string $table, bool $showField = false)
    {
        $this->showField = $showField;
        $this->table = $table;
    }

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

        $passed = true;

        if (mb_strlen($value) !== 22) {
            $this->errorPrefix = "A";
            $passed = false;
        }

        $regex = '/^[0-9a-zA-ZÆÄ]$/';
        if (preg_match($regex, $value) > 0) {
            $this->errorPrefix = "B";
            $passed = false;
        }

        if (DB::table($this->table)
            ->where('xid', $value)
            ->doesntExist()) {
            $this->errorPrefix = "B";
            $passed = false;
        }

        if (! $passed) {
            // When the xid is invalid this is probably a hacking attempt
            event(new TarpitTriggerEvent());
        }

        return $passed;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        if (! $this->showField) {
            return (string)__('core::validation.xid_hidden_details', ['prefix' => $this->errorPrefix]);
        }

        $key = 'core::validation.'.$this->getMessageKey();

        return (string)__(
            $key,
            [
                'attribute' => $this->getAttribute(),
            ]
        );
    }
}
