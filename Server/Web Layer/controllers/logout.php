<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../Domain Layer/models/User.php');
include_once('../../Domain Layer/services/AuthorizationService.php');


$authorizationService = new AuthorizationService();

try {
    $authorizationService->logout();
    header('Location: ' . '..\\..\\client\\views\\index.php');
    http_response_code(302);
} catch (Exception $ex) {

    http_response_code($ex->getCode());
    echo json_encode(array(
        'error' => $ex->getMessage()
    ));
}
