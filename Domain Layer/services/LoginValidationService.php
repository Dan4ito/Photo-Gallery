<?php

include_once('../../Domain Layer/models/User.php');
include_once('../../Domain Layer/services/ValidationService.php');

class LoginValidationService extends ValidationService
{

    public function validateCredentials($userDto)
    {
        $this->validateEmail($userDto->email);
        $this->validatePassword($userDto->password);
        return true;
    }
}
