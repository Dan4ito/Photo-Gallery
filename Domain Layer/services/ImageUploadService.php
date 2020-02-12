<?php

class ImageUploadService
{
    private $imagesFolder = "../../images/";

    public function uploadImages($files, $fileQuality) {
        $imageNames = array();
        $fileNames = $files["name"];
        for ($i = 0; $i < count($fileNames); $i++) {
            $fileTmp = $files['tmp_name'][$i];
            $fileName = $files['name'][$i];

            $fileInfo = getimagesize($fileTmp);
            if($fileInfo['mime'] == 'image/jpeg') {
                $image = imagecreatefromjpeg($fileTmp);
            }
            elseif ($fileInfo['mime'] == 'image/gif') {
                $image = imagecreatefromgif($fileTmp);
            }
            elseif($fileInfo['mime'] == 'image/png') {
                $image = imagecreatefrompng($fileTmp);
            }

            $fileExt = strtolower(explode(".", $fileName)[1]);
            $imageFullName = uniqid("", true) . "." . $fileExt;     // GUID
            $imageDestination = $this->imagesFolder . $imageFullName;
            if (!is_dir($this->imagesFolder)) {
                mkdir($this->imagesFolder);
            }
            
            if($fileQuality == 100) move_uploaded_file($fileTmp, $imageDestination);    // upload the file
            else imagejpeg($image, $imageDestination, $fileQuality);
            array_push($imageNames, $imageFullName);
        }

        return $imageNames;
    }
}
