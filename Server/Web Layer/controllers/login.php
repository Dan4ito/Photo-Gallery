<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: ' . 'Access-Control-Allow-Headers, Content-Type, ' . 'Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once('../dtos/LoginDto.php');
include_once('../../Domain Layer/services/AuthorizationService.php');

$authorizationService = new AuthorizationService();

$data = json_decode(file_get_contents('php://input'));
$loginDto = new LoginDto($data->email, $data->password);

try {
    $authorizationService->login($loginDto);

    header('Location: ' . '..\\..\\client\\views\\index.php');
    http_response_code(302);
} catch (Exception $ex) {

    http_response_code($ex->getCode());
    echo json_encode(array(
        'error' => $ex->getMessage()
    ));
}
