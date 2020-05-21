<?php

include_once('../../Domain Layer/models/User.php');
include_once('../../Domain Layer/services/ValidationService.php');

class LoginValidationService extends ValidationService
{

    public function validateCredentials($loginCredentials)
    {
        $this->validateEmail($loginCredentials->email);
        $this->validatePassword($loginCredentials->password);
        return true;
    }
}
