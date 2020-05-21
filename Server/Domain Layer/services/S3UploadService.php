<?php

use Aws\S3\Exception\S3Exception;
require '../../AWS/start.php';




class S3UploadService
{
    public function uploadImages($files, $fileQuality) {
        $imageNames = array();
        $fileNames = $files["name"];
        for ($i = 0; $i < count($fileNames); $i++) {
            $fileTmp = $files['tmp_name'][$i];
            $fileName = $files['name'][$i];
            
            $fileExt = strtolower(explode(".", $fileName)[1]);
            $imageFullName = uniqid("", true) . "." . $fileExt;     // GUID
            
            if($fileQuality == 100) {
                move_uploaded_file($fileTmp, $fileTmp);
                $this->S3Upload($imageFullName, $fileTmp);
                array_push($imageNames, $imageFullName);
                continue;
            }

            try {
                $fileInfo = getimagesize($fileTmp);
                if($fileInfo['mime'] == 'image/jpeg') {
                    $image = imagecreatefromjpeg($fileTmp);
                    $saveQuality = ($fileQuality / 100) * 95;

                    imagejpeg($image, $fileTmp, $saveQuality);
                }
                elseif($fileInfo['mime'] == 'image/png') {
                    $image = imagecreatefrompng($fileTmp);
                    imagealphablending($image, false);
                    imagesavealpha($image, true);
                    
                    $saveQuality = 9 - ($fileQuality / 100) * 8;
                    imagepng($image, $fileTmp, $saveQuality);             
                }
                $this->S3Upload($imageFullName, $fileTmp);
                array_push($imageNames, $imageFullName);
            } catch (Exception $ex) {
                // TO DO: Log message for corrupted image.
            }
        }

        return $imageNames;
    }

    private function S3Upload($imageName, $imageTempPath){
        try {
            global $config;
            global $s3;
        
            $s3->putObject([
                'Bucket' => $config['s3']['bucket'],
                'Key' => "{$imageName}",
                'Body' => fopen($imageTempPath, 'rb'),
                'ACL' => 'public-read'
            ]);
        
            unlink($imageTempPath);
        
        } catch (S3Exception $e){
            die("There was an error uploading the file to S3");
        }
        
    }
}
