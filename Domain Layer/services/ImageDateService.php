<?php

class ImageDateService
{
    public function getImageDate($fileName)
    {
	$config = require('../../AWS/config.php');
	$imageLocation = 'https://' . $config['s3']['bucket'] . '.s3.amazonaws.com/';
        $fullUrlImage = $imageLocation . $fileName;

	$imagesFolder = "../../images/";
	if (!file_exists($imagesFolder)) {
		mkdir($imagesFolder, 0777, true);
	}
	$explodedName = explode(".", $fileName);
        $count = count($explodedName);
        $fileExt = strtolower($explodedName[$count - 1]);
        $tmpImage = $imagesFolder . "image." . $fileExt;
	copy($fullUrlImage, $tmpImage);
              
	$exif = exif_read_data($tmpImage, 0, true);
        $date = $exif['EXIF']['DateTimeOriginal'];    

	if($date == "") {
		$date = "";
	}

	unlink($tmpImage);
	rmdir(imagesFolder);
	
        return $date;
    }
}
?>


