<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: ' . 'Access-Control-Allow-Headers, Content-Type, ' . 'Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once('../dtos/LoginDto.php');
include_once('../../Domain Layer/models/User.php');
include_once('../../Domain Layer/services/ValidationService.php');
include_once('../../Domain Layer/services/AuthorizationService.php');
include_once('../../Data Layer/repositories/UserRepository.php');

$validationService = new ValidationService();
$authorizationService = new AuthorizationService();
$userRepository = new UserRepository();

$data = json_decode(file_get_contents('php://input'));

$loginDto = new LoginDto($data->email, password_hash($data->password, PASSWORD_DEFAULT));
$user = new User(null, $loginDto->email, $loginDto->password);

try {

    $validationService->validateCredentials($user);
    $user = $userRepository->GetByEmail($user->email);
    if ($user->id != null) {
        $authorizationService->login($user);
        header('Location: ' . '..\\..\\client\\views\\index.php');
        http_response_code(302);
    } else {
        throw new Exception("Invalid credentials", 400);
    }
} catch (Exception $ex) {

    http_response_code($ex->getCode());
    echo json_encode(array(
        'error' => $ex->getMessage()
    ));
}
