<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: ' .
    'Access-Control-Allow-Headers, Content-Type, ' .
    'Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once('../../Data Layer/repositories/ImageRepository.php');
include_once('../../Data Layer/repositories/ImageGalleryRepository.php');
include_once('../../Domain Layer/services/AuthorizationService.php');
include_once('../../Domain Layer/services/SortingValidationService.php');
include_once('../../Domain Layer/services/SortingService.php');

$imageRepository = new ImageRepository();
$imageGalleryRepository = new ImageGalleryRepository();
$sortingValidationService = new SortingValidationService();
$sortingService = new SortingService();
$authorizationService = new AuthorizationService();

try {
    $data = json_decode(file_get_contents('php://input'));
    $galleryId = $data->galleryId;
    $sorting = $data->sorting;

    $user = $authorizationService->getLoggedInUser();
    
    $sortingValidationService->validateSortingType($sorting);
    $images = $imageRepository->GetImagesForGallery($galleryId);
    $imagesSorted = $sortingService->sortImages($images, $sorting);
    
    foreach($images as $image)
    {
        $imageRepository->DeleteImageFromGallery($image->id, $galleryId);
    }

    foreach($imagesSorted as $image)
    {
        $imageId = $imageRepository->Save($image->name, $imageDescription, $user->id);
        $imageGalleryRepository->Create($imageId, $galleryId);
    }

    http_response_code(302);
    header("Location: ../../client/views/gallery.php?id=" . $galleryId);
} catch(Exception $ex) {
    
    http_response_code($ex->getCode());
    echo json_encode(array(
        'error' => $ex->getMessage()
    ));
}
?>