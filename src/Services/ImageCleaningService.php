<?php

namespace Yormy\LaravelValidation\Services;

use Imagick;
use Yormy\LaravelValidation\Exceptions\InvalidImageException;
use Yormy\LaravelValidation\Exceptions\InvalidValueException;

/*
        $imageCleaningService = new ImageCleaningService();
        $imageCleaningService->initBase64($this->screenshotJpeg);
        $imageCleaningService->clean();
        $imageCleaningService->setResolution(30,30);
        $newImage = $imageCleaningService->getBaseJpeg();

        echo "<img src='".$newImage."' />";
 */
class ImageCleaningService
{
    const WEBP_BASE64 = 'data:image/webp;base64,';
    const JPEG_BASE64 = 'data:image/jpeg;base64,';

    private $base64Image;

    private $image;

    protected $resolution = null;

    public function initBase64(string $base64Image) : self
    {
        if ($this->validFormat($base64Image, self::WEBP_BASE64)) {
            $this->base64Image = $this->getBareImage($base64Image, self::WEBP_BASE64);
        }

        if ($this->validFormat($base64Image, self::JPEG_BASE64)) {
            $this->base64Image = $this->getBareImage($base64Image, self::JPEG_BASE64);
        }

        if (!$this->base64Image) {
            throw new InvalidImageException('Invalid Base64');
        }

        return $this;
    }

    public function setResolution(float $x, float $y) : self
    {
        if (0.0 === $x || 0.0 === $y) {
            throw new InvalidValueException('Resolution cannot be 0');
        }

        $this->resolution = [
            'x' => $x,
            'y' => $y,
        ];

        return $this;
    }

    public function clean() : self
    {
        $this->makeImage($this->base64Image);

        $this->stripImage();

        return $this;
    }

    public function resize()
    {
        if (!$this->image) {
            throw new InvalidImageException('Invalid Image');
        }

        if ($this->resolution) {
            $resolution = $this->resolution;
        } else {
            $originalResolution = $this->image->getImageResolution();

            if ($originalResolution['x'] === 0.0 || $originalResolution['y'] == 0.0) {
                $resolution = [
                    'x' => 10,
                    'y' => 10,
                ];
            } else {
                $resolution = [
                    'x' => $originalResolution['x'] - 1,
                    'y' => $originalResolution['y'] - 1,
                ];
            }
        }

        // force some kind of resampling
        $this->image->resampleImage(
            $resolution['x'],
            $resolution['y'],
            \Imagick::FILTER_LANCZOS,
            1
        );
    }

    public function getBaseWebp()
    {
        $this->resize();
        $this->image->setImageFormat('webp');
        $imageString = $this->image->getImageBlob();

        return self::WEBP_BASE64. base64_encode($imageString);
    }

    public function getBaseJpeg()
    {
        $this->resize();
        $this->image->setImageFormat('jpg');
        $this->image->setImageCompressionQuality(85);
        $imageString = $this->image->getImageBlob();

        return self::JPEG_BASE64. base64_encode($imageString);
    }

    private function stripImage()
    {
        $this->image->stripImage();
        $this->image->deleteImageProperty('exif:ExifOffset');
    }

    private function makeImage(string $bareImage) : void
    {
        $this->image = new Imagick();
        $this->image->readImageBlob(base64_decode($bareImage));
    }

    private function validFormat(string $screenshot, string $type) : bool
    {
        if (0 === strpos($screenshot, $type)) {
            return true;
        }

        return false;
    }

    private function getBareImage(string $image, string $type) : string
    {
        return str_replace($type, '', $image);
    }
}
