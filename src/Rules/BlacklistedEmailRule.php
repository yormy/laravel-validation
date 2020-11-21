<?php declare(strict_types=1);

namespace Modules\Core\Rules;

class BlacklistedEmailRule extends Rule
{
    /** @var string */
    protected $className;

    public function __construct(string $className)
    {
        $this->className = $className;
    }

    public function passes($attribute, $value): bool
    {
        $this->setAttribute($attribute);

        $domain = explode("@", $value)[1];

        $model = $this->className;
        $isBlacklisted = $model::where('email_address', '=', $value)
            ->orWhere('email_address', '=', '*@'.$domain)->count();

        if ($isBlacklisted <= 0) {
            return true;
        }

        return false;
    }
}
