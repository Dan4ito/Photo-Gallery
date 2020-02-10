<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: ' .
    'Access-Control-Allow-Headers, Content-Type, ' .
    'Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once('../../Data Layer/repositories/ImageRepository.php');
include_once('../../Data Layer/repositories/ImageGalleryRepository.php');
include_once('../../Domain Layer/services/ImageValidationService.php');
include_once('../../Domain Layer/services/ImageUploadService.php');
include_once('../../Domain Layer/services/AuthorizationService.php');
include_once('../../Domain Layer/services/GalleryUserValidatorService.php');

$imageRepository = new ImageRepository();
$imageGalleryRepository = new ImageGalleryRepository();
$imageValidationService = new ImageValidationService();
$imageUploadService = new ImageUploadService();
$authorizationService = new AuthorizationService();
$galleryUserValidatorService = new GalleryUserValidatorService();


$imageDescription = $_POST['fileDescription'];
$file = $_FILES['file'];
$galleryId = $_POST['galleryId'];

try {
    if ($galleryUserValidatorService->canUserEditGallery($galleryId)) {

        $imageValidationService->validateImage($imageDescription, $file);
        $savedImageName = $imageUploadService->uploadImage($file);
        $user = $authorizationService->getLoggedInUser();
        $imageId = $imageRepository->Save($savedImageName, $imageDescription, $user->id);
        $imageGalleryRepository->Create($imageId, $galleryId);

        http_response_code(302);
        header("Location: ../../client/views/gallery.php?id=" . $galleryId);
    } else {
        throw new Exception("You cannot edit other peoples' galleries!", 400);
    }
} catch (Exception $ex) {

    http_response_code($ex->getCode());
    echo json_encode(array(
        'error' => $ex->getMessage()
    ));
}
