<?php

include_once('../../Domain Layer/models/User.php');

class ValidationService
{

    public function validateCredentials(User $user)
    {
        $this->validateEmail($user->email);
        $this->validatePassword($user->password);
        return true;
    }
    private function validateEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Email is invalid', 400);
        } else if (strlen($email) > 255) {
            throw new Exception('Email is too long', 400);
        }
    }

    private function validatePassword($password)
    {
        if (strlen($password) <= 0) {
            throw new Exception('Password is invalid', 400);
        }
    }
}
