<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: ' .
    'Access-Control-Allow-Headers, Content-Type, ' .
    'Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once('../../Domain Layer/services/AuthorizationService.php');
include_once('../../Domain Layer/services/GalleryService.php');

$galleryService = new GalleryService();
$authorizationService = new AuthorizationService();

try {
    $data = json_decode(file_get_contents('php://input'));

    $galleryId = $data->galleryId;

    $user = $authorizationService->getLoggedInUser();
    $galleryService->DeleteGallery($galleryId, $user);

    http_response_code(302);
    header("Location: ../../client/views/myGalleries.php");
} catch (Exception $ex) {

    http_response_code($ex->getCode());
    echo json_encode(array(
        'error' => $ex->getMessage()
    ));
}
