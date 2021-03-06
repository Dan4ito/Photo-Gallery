<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: ' .
    'Access-Control-Allow-Headers, Content-Type, ' .
    'Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once('../../Domain Layer/services/GalleryUserValidatorService.php');
include_once('../../Data Layer/repositories/ImageRepository.php');

$galleryUserValidatorService = new GalleryUserValidatorService();
$imageRepository = new ImageRepository();

try {
    $data = json_decode(file_get_contents('php://input'));
    $imageId = $data->imageId;
    $galleryId = $data->galleryId;

    if ($galleryUserValidatorService->isUserGalleryOwner($galleryId)) {

        $imageRepository->DeleteImageFromGallery($imageId, $galleryId);
        http_response_code(302);
        header("Location: ../../client/views/gallery.php?id=" . $galleryId);
    } else {
        throw new Exception("You cannot delete other peoples' galleries!", 400);
    }
} catch (Exception $ex) {
    http_response_code($ex->getCode());
    echo json_encode(array(
        'error' => $ex->getMessage()
    ));
}
