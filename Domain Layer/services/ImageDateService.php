<?php

class ImageDateService
{
    public function getImageDate($fileName)
    {
        $imageLocation = 'https://' . $config['s3']['bucket'] . '.s3.amazonaws.com/';
        $imageFullName = $imageLocation.$fileName;
        $exif = exif_read_data($imageFullName, 0, true);
        $date = $exif['EXIF']['DateTimeOriginal'];
        
        if($date == "")
        {
            $date = "2000-07-09 12:45:11";
        } 
        return $date;
    }
}
?>

