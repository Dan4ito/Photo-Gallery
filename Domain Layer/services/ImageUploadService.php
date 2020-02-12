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
            
            $fileExt = strtolower(explode(".", $fileName)[1]);
            $imageFullName = uniqid("", true) . "." . $fileExt;     // GUID
            $imageDestination = $this->imagesFolder . $imageFullName;
            if (!is_dir($this->imagesFolder)) {
                mkdir($this->imagesFolder);
            }

            $fileInfo = getimagesize($fileTmp);
            if($fileInfo['mime'] == 'image/jpeg') {
                $image = imagecreatefromjpeg($fileTmp);
                $fileQuality = ($fileQuality / 100) * 90;

                imagejpeg($image, $imageDestination, $fileQuality);
            }
            elseif($fileInfo['mime'] == 'image/png') {
                $image = imagecreatefrompng($fileTmp);
                imagealphablending($image, false);
                imagesavealpha($image, true);
                
                $fileQuality = 9 - ($fileQuality / 100) * 8;
                imagepng($image, $imageDestination, $fileQuality);
            }

            array_push($imageNames, $imageFullName);
        }

        return $imageNames;
    }
}
