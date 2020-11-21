<?php declare(strict_types=1);

namespace Modules\Core\Rules;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Core\Rules\Exceptions\RuleSetupException;

/**
 * Requires the authenticated user's id to match the user_id column on a given database record e.g. owner:posts,id
 * Class RecordOwner
 * @package Modules\Core\Rules
 */
class RecordOwner extends Rule
{
    private $table;
    private $column;

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
            ->where('user_id', Auth::id())
            ->exists();
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
