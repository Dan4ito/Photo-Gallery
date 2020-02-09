<?php

include_once('../../Domain Layer/models/User.php');
include_once('../../Domain Layer/services/ValidationService.php');

class LoginValidationService extends ValidationService
{

    public function validateCredentials(User $user)
    {
        $this->validateEmail($user->email);
        $this->validatePassword($user->password);
        return true;
    }
}
