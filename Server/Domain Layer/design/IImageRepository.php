
<?php

interface IImageRepository
{
    public function Save(string $savedImageName, string $imageDescription, int $authorId);
    public function GetImagesForGallery(int $galleryId);
    public function GetImagesForGalleries($galleryIds);
    public function GetImageTags(int $imageId);
    
    public function GetTopImageForGallery(int $galleryId);
    public function DeleteImageFromGallery(int $imageId, int $galleryId);
}
?> 
  