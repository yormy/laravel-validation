<?php declare(strict_types = 1);

namespace Yormy\LaravelValidation\Rules;

use Illuminate\Support\Facades\DB;

use Yormy\LaravelValidation\Rules\Exceptions\RuleSetupException;

/**
 * Requires that the given value is not present in a given database table / column - see class for details
 * Class Missing
 * @package Axiom\Rules
 */
class MissingInDb extends Rule
{
    private $table = null;
    private $column = null;

    /**
     * Determine if the validation rule passes.
     *
     * The rule requires two parameters:
     * 1. The database table to use.
     * 2. The column on the table to compare the value against.
     *
     **/
    public function passes($attribute, $value) : bool
    {
        $this->setAttribute($attribute);

        if ($this->table === null) {
            throw new RuleSetupException('use ->table() to specify the table to check');
        }

        if ($this->column === null) {
            throw new RuleSetupException('use ->column() to specify the column to check');
        }

        return DB::table($this->table)
            ->where($this->column, $value)
            ->doesntExist();
    }

    public function table(string $table): self
    {
        $this->table = $table;

        return $this;
    }

    public function column(string $column): self
    {
        $this->column = $column;

        return $this;
    }
}
