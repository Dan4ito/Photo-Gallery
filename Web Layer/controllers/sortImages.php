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
include_once('../../Domain Layer/services/ReloadingImagesService.php');

$imageRepository = new ImageRepository();
$sortingValidationService = new SortingValidationService();
$sortingService = new SortingService();
$authorizationService = new AuthorizationService();
$reloadingImagesService = new ReloadingImagesService();

try {
    
    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $data = array();
        parse_str($_SERVER['QUERY_STRING'], $data);
        $galleryId = intval($data['id']);
        $sorting = $data['type'];

        $sortingValidationService->validateSortingType($sorting);
        $imagesSorted = $sortingService->sortImages($galleryId, $sorting);
        $user = $authorizationService->getLoggedInUser();
        $reloadingImagesService->reloadImagesForUserGallery($imagesSorted, $galleryId, $user);        
    
        http_response_code(302);
        header("Location: ../../client/views/gallery.php?id=" . $galleryId);
        } 
    else 
    {
        throw new Exception("Unsupported method!", 400);
    }
} catch(Exception $ex) {
    
    http_response_code($ex->getCode());
    echo json_encode(array(
        'error' => $ex->getMessage()
    ));
}
?>