<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: ' .
    'Access-Control-Allow-Headers, Content-Type, ' .
    'Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once('../../Domain Layer/services/GalleryUserValidatorService.php');
include_once('../../Data Layer/repositories/GalleryRepository.php');

$galleryUserValidatorService = new GalleryUserValidatorService();
$galleryRepository = new GalleryRepository();

try {
    $data = json_decode(file_get_contents('php://input'));
    $galleryId = $data->galleryId;

    if ($galleryUserValidatorService->canUserDeleteGallery($galleryId)) {

        $galleryRepository->DeleteGallery($galleryId);
        http_response_code(302);
        header("Location: ../../client/views/myGalleries.php");
    } else {
        throw new Exception("You cannot delete other peoples' galleries!", 400);
    }
} catch (Exception $ex) {
    http_response_code($ex->getCode());
    echo json_encode(array(
        'error' => $ex->getMessage()
    ));
}
