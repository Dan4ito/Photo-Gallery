<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: ' .
    'Access-Control-Allow-Headers, Content-Type, ' .
    'Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once('../../Domain Layer/services/GalleryService.php');

$galleryService = new GalleryService();


$imagesDescription = $_POST['fileDescription'];
$galleryId = $_POST['galleryId'];
$selectedTags = ($_POST['selectedTags'] != "") ? explode(",", $_POST['selectedTags']) : null;
$fileQuality = $_POST['fileQuality'];
$files = $_FILES['files'];

try {
    $galleryService->AddImagesToGallery($files, $fileQuality, $imagesDescription, $selectedTags, $galleryId);
    http_response_code(302);
    header("Location: ../../client/views/gallery.php?id=" . $galleryId);
} catch (Exception $ex) {
    http_response_code($ex->getCode());
    echo json_encode(array(
        'error' => $ex->getMessage()
    ));
}
