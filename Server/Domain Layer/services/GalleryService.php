<?php

include_once('../../Data Layer/repositories/GalleryRepository.php');
include_once('../../Data Layer/repositories/ImageRepository.php');
include_once('../../Data Layer/repositories/ImageGalleryRepository.php');
include_once('../../Data Layer/repositories/ImageTagRepository.php');
include_once('../../Data Layer/repositories/TagRepository.php');
include_once('../../Domain Layer/services/GalleryValidationService.php');
include_once('../../Domain Layer/services/AuthorizationService.php');
include_once('../../Domain Layer/services/GalleryUserValidatorService.php');
include_once('../../Domain Layer/services/ImageValidationService.php');
include_once('../../Domain Layer/services/S3UploadService.php');
include_once('../../Domain Layer/enums/Tags.php');

class GalleryService
{

    private $galleryRepository;
    private $galleryValidationService;
    private $authorizationService;
    private $galleryUserValidatorService;
    private $imageRepository;
    private $imageGalleryRepository;
    private $imageValidationService;
    private $S3UploadService;
    private $imageTagRepository;
    private $tagRepository;

    function __construct()
    {
        $this->galleryRepository = new GalleryRepository();
        $this->galleryValidationService = new GalleryValidationService();
        $this->authorizationService = new AuthorizationService();
        $this->galleryUserValidatorService = new GalleryUserValidatorService();
        $this->imageRepository = new ImageRepository();
        $this->imageGalleryRepository = new ImageGalleryRepository();
        $this->imageValidationService = new ImageValidationService();
        $this->S3UploadService = new S3UploadService();
        $this->imageTagRepository = new ImageTagRepository();
        $this->tagRepository = new TagRepository();
    }

    public function MergeGalleries($galleryName, $galleryIds)
    {
        $this->galleryValidationService->validateGallery($galleryName);
        if ($this->galleryUserValidatorService->canUserViewGalleries($galleryIds)) {
            $createdGalleryId = $this->galleryRepository->Create($galleryName, $this->authorizationService->getLoggedInUser()->id);
            $imagesForAllGalleries = $this->imageRepository->GetImagesForGalleries($galleryIds);
            $imagesIds = array_map(function ($image) {
                return $image->id;
            }, $imagesForAllGalleries);
            $imagesIds = array_values(array_unique($imagesIds));
            $this->imageGalleryRepository->InsertImagesForGallery($imagesIds, $createdGalleryId);
        }
    }

    public function AddImagesToGallery($files, $fileQuality, $imagesDescription, $selectedTags, $galleryId)
    {
        if ($this->galleryUserValidatorService->canUserEditGallery($galleryId)) {
            $this->imageValidationService->validateImages($imagesDescription, $files);
            $savedImageNames = $this->S3UploadService->uploadImages($files, $fileQuality);

            $user = $this->authorizationService->getLoggedInUser();

            foreach ($savedImageNames as $savedImageName) {
                $imageId = $this->imageRepository->Save($savedImageName, $imagesDescription, $user->id);
                $this->imageGalleryRepository->Create($imageId, $galleryId);
                if ($selectedTags != null) {
                    foreach ($selectedTags as $tagName) {
                        $tagId = $this->tagRepository->CreateTagIfMissing($tagName);
                        if ($tagId == 0) $tagId = $this->tagRepository->GetTag($tagName)->id;
                        $this->imageTagRepository->Create($imageId, $tagId);
                    }
                }
            }
        } else {
            throw new Exception("You cannot edit other peoples' galleries!", 400);
        }
    }

    public function DeleteGallery($galleryId)
    {
        if ($this->galleryUserValidatorService->isUserGalleryOwner($galleryId)) {
            $this->galleryRepository->DeleteGallery($galleryId);
        } else {
            throw new Exception("You cannot delete other peoples' galleries!", 400);
        }
    }

    public function CreateGallery($galleryName)
    {
        $this->galleryValidationService->validateGallery($galleryName);
        $user = $this->authorizationService->getLoggedInUser();
        $this->galleryRepository->Create($galleryName, $user->id);
    }

}
