<?php

class ImageUploadService
{
    private $imagesFolder = "../../images/";
    public function uploadImage($file)
    {
        $fileTemp = $file['tmp_name'];
        $fileName = $file['name'];
        $fileExt = strtolower(explode(".", $fileName)[1]);
        $imageFullName = uniqid("", true) . "." . $fileExt;     // GUID

        $imageDestination = $this->imagesFolder . $imageFullName;
        if(!is_dir($this->imagesFolder)) {
            mkdir($this->imagesFolder);
        }
        move_uploaded_file($fileTemp, $imageDestination);    // upload the file
        return $imageFullName;
    }
}
