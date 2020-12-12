<?php declare(strict_types = 1);
/*
Determine if the user is authorized to perform an ability on an instance of the given model.
The id of the model is the field under validation

Consider the following policy:

class ModelPolicy
{
    use HandlesAuthorization;

    public function edit(User $user, Model $model): bool
    {
        return $model->user->id === $user->id;
    }
}
This validation rule will pass if the id of the logged in user matches the user_id on TestModel
who's it is in the model_id key of the request.

// in a `FormRequest`

use Spatie\ValidationRules\Rules\Authorized;

public function rules()
{
    return [
        'model_id' => [new Authorized('edit', TestModel::class)],
    ];
}
*/
namespace Yormy\LaravelValidation\Rules;

use Illuminate\Support\Facades\Auth;

/**
 * Determine if the user is authorized to perform an ability on an instance of the given model.
 * The id of the model is the field under validation
 * https://github.com/spatie/laravel-validation-rules
 * Class Authorized
 * @package Modules\Core\Rules
 */
class Authorized extends Rule
{
    /** @var string */
    protected $ability;

    /** @var array */
    protected $arguments;

    /** @var string */
    protected $className;

    public function __construct(string $ability, string $className)
    {
        $this->ability = $ability;

        $this->className = $className;
    }

    public function passes($attribute, $value): bool
    {
        $this->setAttribute($attribute);

        /**
         * @var Authenticatable user
         */
        $user = Auth::user();
        if (! $user) {
            return false;
        }

        if (! $model = $this->className::find($value)) {
            return false;
        }

        return $user->can($this->ability, $model);
    }

    /**
     * @return string
     */
    public function message(): string
    {
        $classBasename = class_basename($this->className);

        $key = 'core::validation.'.$this->getMessageKey();

        $message = (string)__(
            $key,
            [
                'attribute' => $this->attribute,
                'ability' => $this->ability,
                'className' => $classBasename,
            ]
        );

        return $message;
    }
}
