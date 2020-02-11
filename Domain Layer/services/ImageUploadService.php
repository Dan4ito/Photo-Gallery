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
            elseif ($info['mime'] == 'image/gif') {
                $image = imagecreatefromgif($source);
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
            imagejpeg($image, $imageDestination, $fileQuality);
            array_push($imageNames, $imageFullName);
        }

        return $imageNames;
    }
}
