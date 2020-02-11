
<?php

interface IImageGalleryRepository
{
    public function Create(int $imageId, int $galleryId);
    public function InsertImagesForGallery($imageIds, int $galleryId);
}
?> 
  