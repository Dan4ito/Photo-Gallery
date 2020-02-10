<?php
include_once('../../Data Layer/repositories/GalleryRepository.php');
include_once('../../Data Layer/repositories/TypeRepository.php');
include_once('../../Domain Layer/services/AuthorizationService.php');
include_once('../../Domain Layer/enums/GalleryTypes.php');

class GalleryUserValidatorService
{
    private $authorizationService;
    private $galleryRepository;
    private $typeRepository;

    function __construct()
    {
        $this->authorizationService = new AuthorizationService();
        $this->galleryRepository = new GalleryRepository();
        $this->typeRepository = new TypeRepository();
    }

    public function canUserViewGallery(int $galleryId)
    {
        $user = $this->authorizationService->getLoggedInUser();
        $gallery = $this->galleryRepository->GetById($galleryId);

        $galleryType = $this->typeRepository->GetById($gallery->typeId);
        if ($galleryType->type == GalleryTypes::PUBLIC) {
            return true;
        }
        if ($galleryType->type == GalleryTypes::PRIVATE && $gallery->userId == $user->id) {
            return true;
        } else {
            return false;
        }
    }

    public function canUserToggleGalleryType(int $galleryId)
    {
        $user = $this->authorizationService->getLoggedInUser();
        $gallery = $this->galleryRepository->GetById($galleryId);

        if ($gallery->userId == $user->id) {
            return true;
        } else {
            return false;
        }
    }
}
