<?php declare(strict_types = 1);

namespace Yormy\LaravelValidation\Rules;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileNotExists extends Rule
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $filename;

    /** @var bool */
    protected $includePrefix = true;

    /**
     * FileExtension constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
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

        /**
         * @var UploadedFile $value
         */
        $this->filename = $value->getClientOriginalName();

        return ! Storage::exists($this->path . '/' . $this->filename);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
//    public function message()
//    {
//        return __('Bestand :filename bestaat al', ['filename' => $this->filename]);
//    }

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
            ]
        );

        if ($this->includePrefix) {
            return $message. "; ". __($key.'.prefix');
        }

        return $message;
    }
}
