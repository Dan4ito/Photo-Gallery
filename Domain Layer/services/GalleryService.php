<?php

include_once('../../Data Layer/repositories/GalleryRepository.php');
include_once('../../Data Layer/repositories/ImageRepository.php');
include_once('../../Data Layer/repositories/ImageGalleryRepository.php');
include_once('../../Domain Layer/services/GalleryValidationService.php');
include_once('../../Domain Layer/services/AuthorizationService.php');
include_once('../../Domain Layer/services/GalleryUserValidatorService.php');

class GalleryService
{

    private $galleryRepository;
    private $galleryValidationService;
    private $authorizationService;
    private $galleryUserValidatorService;
    private $imageRepository;
    private $imageGalleryRepository;

    function __construct()
    {
        $this->galleryRepository = new GalleryRepository();
        $this->galleryValidationService = new GalleryValidationService();
        $this->authorizationService = new AuthorizationService();
        $this->galleryUserValidatorService = new GalleryUserValidatorService();
        $this->imageRepository = new ImageRepository();
        $this->imageGalleryRepository = new ImageGalleryRepository();
    }

    public function MergeGalleries($galleryName, $galleryIds)
    {
        $this->galleryValidationService->validateGallery($galleryName);
        if($this->galleryUserValidatorService->canUserViewGalleries($galleryIds)){
            $createdGalleryId = $this->galleryRepository->Create($galleryName, $this->authorizationService->getLoggedInUser()->id);
            $imagesForAllGalleries = $this->imageRepository->GetImagesForGalleries($galleryIds);
            $imagesIds = array_map(function ($image) {
                return $image->id;
            }, $imagesForAllGalleries);
            $imagesIds = array_values(array_unique($imagesIds));
            $this->imageGalleryRepository->InsertImagesForGallery($imagesIds, $createdGalleryId);
        }
    }
}
