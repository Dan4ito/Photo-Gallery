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
            
            if($fileQuality == 100) {
                move_uploaded_file($fileTmp, $imageDestination);
                array_push($imageNames, $imageFullName);
                continue;
            }

            try {
                $fileInfo = getimagesize($fileTmp);
                if($fileInfo['mime'] == 'image/jpeg') {
                    $image = imagecreatefromjpeg($fileTmp);
                    $saveQuality = ($fileQuality / 100) * 95;

                    imagejpeg($image, $imageDestination, $saveQuality);
                }
                elseif($fileInfo['mime'] == 'image/png') {
                    $image = imagecreatefrompng($fileTmp);
                    imagealphablending($image, false);
                    imagesavealpha($image, true);
                    
                    $saveQuality = 9 - ($fileQuality / 100) * 8;
                    imagepng($image, $imageDestination, $saveQuality);
                }
                
                array_push($imageNames, $imageFullName);
            } catch (Exception $ex) {
                // TO DO: Log message for corrupted image.
            }
        }

        return $imageNames;
    }
}
