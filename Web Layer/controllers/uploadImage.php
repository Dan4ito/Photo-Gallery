<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: ' .
    'Access-Control-Allow-Headers, Content-Type, ' .
    'Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once('../../Data Layer/repositories/ImageRepository.php');
include_once('../../Domain Layer/services/ImageValidationService.php');
include_once('../../Domain Layer/services/ImageUploadService.php');
include_once('../../Domain Layer/services/AuthorizationService.php');

$imageRepository = new ImageRepository();
$imageValidationService = new ImageValidationService();
$imageUploadService = new ImageUploadService();
$authorizationService = new AuthorizationService();


$imageDescription = $_POST['fileDescription'];
$file = $_FILES['file'];

$imageValidationService->validateImage($imageDescription, $file);
$savedImageName = $imageUploadService->uploadImage($file);
$user = $authorizationService->getLoggedInUser();
$imageRepository->Save($savedImageName, $imageDescription, $user->id);

header("Location: ../gallery.php?upload=success");
