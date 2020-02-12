<?php

include_once('../../Data Layer/repositories/ImageRepository.php');

class ReloadingImagesService 
{
    private $imageRepository;
    private $imageGalleryRepository;

    public function __construct()
    {
        $this->imageRepository = new ImageRepository();
        $this->imageGalleryRepository = new ImageGalleryRepository();
    }

    public function reloadImagesForUserGallery($imagesSorted, $galleryId, $user) 
    {
        $images = $this->imageRepository->GetImagesForGallery($galleryId);

        foreach($images as $image)
        {
            $this->imageRepository->DeleteImageFromGallery($image->id, $galleryId);
        }

        foreach($imagesSorted as $image)
        {
            $imageId = $this->imageRepository->Save($image->name, $image->description, $user->id, $image->timestamp);
            $this->imageGalleryRepository->Create($imageId, $galleryId);
        }
    }
}

?>
 
