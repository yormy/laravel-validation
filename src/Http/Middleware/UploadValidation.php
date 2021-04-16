<?php

namespace Yormy\LaravelValidation\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Yormy\LaravelValidation\Exceptions\BlacklistedContentException;
use Yormy\LaravelValidation\Exceptions\ExtensionInconsistentException;
use Yormy\LaravelValidation\Exceptions\ExtensionInvalidException;
use Yormy\LaravelValidation\Exceptions\MimeInconsistentException;
use Yormy\LaravelValidation\Exceptions\MimeTypeNotAllowedException;
use Yormy\LaravelValidation\Exceptions\NullByteFoundException;
use Yormy\LaravelValidation\Exceptions\SizeNotAllowedException;
use Yormy\LaravelValidation\Observers\Events\BlacklistedContentEvent;
use Yormy\LaravelValidation\Observers\Events\ExtensionInconsistentEvent;
use Yormy\LaravelValidation\Observers\Events\ExtensionInvalidEvent;
use Yormy\LaravelValidation\Observers\Events\MimeInconsistentEvent;
use Yormy\LaravelValidation\Observers\Events\MimeNotAllowedEvent;
use Yormy\LaravelValidation\Observers\Events\NullByteFoundEvent;
use Yormy\LaravelValidation\Observers\Events\SizeNotAllowedEvent;


class UploadValidation
{
    public function handle($request, Closure $next)
    {
        $uploadedFiles = $request->allFiles();
        if (!$uploadedFiles) {
            return $next($request);
        }

        foreach ($uploadedFiles as $uploadedFile) {
            $this->checkNullByte($uploadedFile);
            $this->checkSizeAllowed($uploadedFile);
            $this->checkMimeAllowed($uploadedFile);
            $this->checkMimeInconsistent($uploadedFile);
            $this->checkExtensionInconsistent($uploadedFile);
            $this->checkExtensionInvalid($uploadedFile);
            $this->checkContentBlacklist($uploadedFile);
        }

        return $next($request);
    }

    private function checkNullByte(UploadedFile $file)
    {
        $clientOriginalName = $file->getClientOriginalName();

        $clientOriginalNameWithoutNull = str_replace(chr(0), '', $clientOriginalName);

        if ($clientOriginalName !== $clientOriginalNameWithoutNull) {
            NullByteFoundEvent::dispatch($clientOriginalName);

            if ($this->canThrowException('NullByteFoundException')) {
                throw new NullByteFoundException($clientOriginalName);
            }
        }
    }

    private function canThrowException(string $exceptionName)
    {
        return in_array($exceptionName, config('laravel-validation.upload.exceptions'));
    }

    private function checkSizeAllowed(UploadedFile $file)
    {
        if ($file->getSize() > config('laravel-validation.upload.max_file_size_kb')) {

            $clientOriginalName = $file->getClientOriginalName();

            SizeNotAllowedEvent::dispatch($clientOriginalName);

            if ($this->canThrowException('SizeNotAllowedException')) {
                throw new SizeNotAllowedException($clientOriginalName);
            }
        }
    }

    private function checkMimeAllowed(UploadedFile $file)
    {
        $allowedMimeTypes = array_keys(config('laravel-validation.upload.mime_allowed'));
        $uploadedMimeType = $file->getMimeType();

        if (!in_array($uploadedMimeType, $allowedMimeTypes)) {

            $clientOriginalName = $file->getClientOriginalName();
            MimeNotAllowedEvent::dispatch($clientOriginalName, $uploadedMimeType);

            if ($this->canThrowException('MimeTypeNotAllowedException')) {
                throw new MimeTypeNotAllowedException($clientOriginalName, $uploadedMimeType);
            }
        }
    }

    private function checkMimeInconsistent(UploadedFile $file)
    {
        if (config('laravel-validation.upload.inconsistent_mime')) {
            $uploadedMimeType = $file->getMimeType();
            if ($file->getClientMimeType() !== $uploadedMimeType) {

                $clientOriginalName = $file->getClientOriginalName();

                MimeInconsistentEvent::dispatch($clientOriginalName, $uploadedMimeType);

                if ($this->canThrowException('InconsistentMimeException')) {
                    throw new MimeInconsistentException($clientOriginalName);
                }
            }
        }
    }

    private function checkExtensionInconsistent(UploadedFile $file)
    {
        if (config('laravel-validation.upload.inconsistent_extension')) {
            if ($file->guessExtension() !== $file->guessClientExtension()) {

                $clientOriginalName = $file->getClientOriginalName();

                ExtensionInconsistentEvent::dispatch($clientOriginalName);

                if ($this->canThrowException('ExtensionInconsistentException')) {
                    throw new ExtensionInconsistentException($clientOriginalName);
                }
            }
        }
    }

    private function checkExtensionInvalid(UploadedFile $file)
    {
        if (config('laravel-validation.upload.inconsistent_mime_extension')) {
            $extensionsAllowedForMime = config('laravel-validation.upload.mime_allowed')[$file->getClientMimeType()];
            if ($extensionsAllowedForMime && !in_array($file->guessClientExtension(), $extensionsAllowedForMime)) {

                $clientOriginalName = $file->getClientOriginalName();

                ExtensionInvalidEvent::dispatch($clientOriginalName);

                if ($this->canThrowException('ExtensionInvalidException')) {
                    throw new ExtensionInvalidException($clientOriginalName);
                }
            }
        }
    }

    private function checkContentBlacklist(UploadedFile $file)
    {
        $blacklistedItems = config('laravel-validation.upload.content_blacklist');

        $content = $file->get();
        foreach ($blacklistedItems as $maliciousContent) {
            if (strpos($content, $maliciousContent) !== false) {

                $clientOriginalName = $file->getClientOriginalName();

                BlacklistedContentEvent::dispatch($clientOriginalName, $maliciousContent);

                if ($this->canThrowException('BlacklistedContentException')) {
                    throw new BlacklistedContentException($clientOriginalName, $maliciousContent);
                }
            }
        }
    }


}
