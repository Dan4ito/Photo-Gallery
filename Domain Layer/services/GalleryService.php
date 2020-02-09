<?php
include_once(__DIR__ . '/../models/User.php');
include_once('../../Data Layer/repositories/GalleryRepository.php');

class GalleryService
{
    public $galleryRepository;

    function __construct()
    {
        $this->galleryRepository = new GalleryRepository();
    }

    public function DeleteGallery(int $galleryId, User $user)
    {
        $gallery = $this->galleryRepository->GetById($galleryId);
        if($gallery['userId'] == $user->id){
            $this->galleryRepository->DeleteGallery($galleryId);
        }
        else{
            throw new Exception("You cannot delete other peoples' galleries!");
        }
    }

}
