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
include_once('../../Domain Layer/services/ImageUploadService.php');
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
    private $imageUploadService;
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
        $this->imageUploadService = new ImageUploadService();
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
            $savedImageNames = $this->imageUploadService->uploadImages($files, $fileQuality);


            $dbTags = $this->tagRepository->GetAllTags();
            $pickedTags = array_map(function ($tag) {
                return $tag->id;
            }, array_filter($dbTags, function ($dbTag) use ($selectedTags) {
                return (in_array($dbTag->tag, $selectedTags));
            }));

            $user = $this->authorizationService->getLoggedInUser();

            foreach ($savedImageNames as $savedImageName) {
                $imageId = $this->imageRepository->Save($savedImageName, $imagesDescription, $user->id);
                $this->imageGalleryRepository->Create($imageId, $galleryId);
                if (count($pickedTags) > 0) {
                    $this->imageTagRepository->Create($imageId, $pickedTags);
                }
            }
        } else {
            throw new Exception("You cannot edit other peoples' galleries!", 400);
        }
    }
}
