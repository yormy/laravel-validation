<?php declare(strict_types=1);

/*
Determine if all of the values in the input array exist as attributes for the given model class.

By default the rule assumes that you want to validate using id attribute.
In the example below the validation will pass if all model_ids exist for the Model.

// in a `FormRequest`

use Spatie\ValidationRules\Rules\ModelsExist;

public function rules()
{
    return [
        'model_ids' => ['array', new ModelsExist(Model::class)],
    ];
}
You can also pass an attribute name as the second argument.
In the example below the validation will pass if there are users for each email given in the user_emails of the request.

// in a `FormRequest`

use Spatie\ValidationRules\Rules\ModelsExist;

public function rules()
{
    return [
        'user_emails' => ['array', new ModelsExist(User::class, 'emails')],
    ];
}
*/

namespace Modules\Core\Rules;

use Modules\Core\Rules\Rule;

/**
 * Determine if all of the values in the input array exist as attributes for the given model class.
 * By default the rule assumes that you want to validate using id attribute.
 * In the example below the validation will pass if all model_ids exist for the Model.
 * https://github.com/spatie/laravel-validation-rules
 * Class ModelsExist
 * @package Modules\Core\Rules
 */
class ModelsExist extends Rule
{
    /** @var string */
    protected $modelClassName;

    /** @var string */
    protected $modelAttribute;

    /** @var array */
    protected $modelIds;

    public function __construct(string $modelClassName, string $attribute = 'id')
    {
        $this->modelClassName = $modelClassName;

        $this->modelAttribute = $attribute;
    }

    public function passes($attribute, $value): bool
    {
        $this->setAttribute($attribute);

        $value = array_filter($value);

        $this->modelIds = array_unique($value);

        $modelCount = $this->modelClassName::whereIn($this->modelAttribute, $this->modelIds)->count();

        return count($this->modelIds) === $modelCount;
    }

    public function message(): string
    {
        $modelIds = implode(', ', $this->modelIds);

        $classBasename = class_basename($this->modelClassName);

        return __('validationRules::messages.model_ids', [
            'attribute' => $this->attribute,
            'model' => $classBasename,
            'modelAttribute' => $this->modelAttribute,
            'modelIds' => $modelIds,
        ]);
    }
}
