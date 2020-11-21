<?php declare(strict_types=1);

namespace Modules\Core\Rules;

use Modules\Core\Rules\Exceptions\RuleSetupException;
use Modules\Core\Rules\Rule;
use Illuminate\Support\Str;

use function __;
use function array_map;
use function explode;
use function filter_var;
use function implode;
use function in_array;

/**
 * Only allow emails from whitelisted list of domains
 * ->validDomains(['gmail.com','laravel.com',]),
 * Class DomainRestrictedEmail
 * @package Modules\Core\Rules
 */
class DomainRestrictedEmail extends Rule
{
    /** @var array */
    protected $validDomains = [];

    /**
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $this->setAttribute($attribute);

        if ($this->validDomains === []) {
            throw new RuleSetupException('Zero domains have been whitelisted using the "validDomains()" method');
        }

        if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $domain = (string) explode('@', $value)[1];

        return in_array($domain, $this->validDomains);
    }

    /**
     * @param  array  $domains
     * @return self
     */
    public function validDomains(array $domains): self
    {
        $this->validDomains = $domains;

        return $this;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return __(
            'core::validation.'.$this->getMessageKey(),
            [
                'attribute' => $this->getAttribute(),
                'plural'    => Str::plural('domain', count($this->validDomains)),
                'domains'   => implode(
                    ', ',
                    array_map(
                        function ($domain) {
                            return '@'.$domain;
                        },
                        $this->validDomains
                    )
                ),
            ]
        );
    }
}
