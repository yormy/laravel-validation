## Usage

``` php
        $imageCleaningService = new ImageCleaningService();
        $imageCleaningService->initBase64($this->screenshotJpeg);
        $imageCleaningService->clean();
        $imageCleaningService->setResolution(30,30);
        $newImage = $imageCleaningService->getBaseJpeg();

        echo "<img src='".$newImage."' />";
```
