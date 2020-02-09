<?php

include_once('../../Domain Layer/models/User.php');
include_once('../../Domain Layer/services/ValidationService.php');

class RegisterValidationService extends ValidationService
{

    public function validateCredentials(User $user)
    {
        $this->validateUsername($user->username);
        $this->validateEmail($user->email);
        $this->validatePassword($user->password);
        return true;
    }
}
