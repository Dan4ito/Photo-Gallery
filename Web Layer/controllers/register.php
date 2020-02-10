<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: ' .
    'Access-Control-Allow-Headers, Content-Type, ' .
    'Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once('../dtos/RegisterDto.php');
include_once('../../Domain Layer/models/User.php');
include_once('../../Domain Layer/services/RegisterValidationService.php');
include_once('../../Data Layer/repositories/UserRepository.php');

$registerValidationService = new RegisterValidationService();
$userRepository = new UserRepository();

$data = json_decode(file_get_contents('php://input'));

$registerDto = new RegisterDto($data->username, $data->email, password_hash($data->password, PASSWORD_DEFAULT));
$user = new User(null, $registerDto->username, $registerDto->email, $registerDto->password);

try {
    $registerValidationService->validateCredentials($user);
    $userRepository->AddUser($user);
    http_response_code(201);
} catch (Exception $ex) {

    http_response_code($ex->getCode());
    echo json_encode(array(
        'error' => $ex->getMessage()
    ));
}
