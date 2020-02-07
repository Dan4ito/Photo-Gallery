
<?php

interface IImageRepository
{
    public function Save($savedImageName, $imageDescription, $authorId);
    public function GetImages();
}
?> 
  