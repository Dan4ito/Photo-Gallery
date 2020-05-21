<?php
class ImageValidationService
{
    private $allowed = array("jpg", "jpeg", "png");
    private $maxSize_MB = 20971520;   // 20mb

    public function validateImages($imageDescription, $files)
    {
        $fileNames = $files["name"];
        for ($i = 0; $i < count($fileNames); $i++) {
            $fileName = $files['name'][$i];
            $fileError = $files['error'][$i];
            $fileSize = $files['size'][$i];

            $fileExt = strtolower(explode(".", $fileName)[1]);

            if (empty($imageDescription)) {
                throw new Exception("Missing description", 400);
            }
            if (!in_array($fileExt, $this->allowed)) {
                throw new Exception("You need to upload a proper file type!", 400);
            }
            if ($fileError > 0) {
                throw new Exception("You had an upload error", 400);
            }
            if ($fileSize > $this->maxSize_MB) {
                throw new Exception("File size is too big", 400);
            }
        }
    }
}
