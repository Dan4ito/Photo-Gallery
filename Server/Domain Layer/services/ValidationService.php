<?php

include_once('../../Domain Layer/models/User.php');

class ValidationService
{
    protected function validateUsername($username)
    {
        if (strlen($username) <= 0) {
            throw new Exception('Username is invalid', 400);
        }
    }

    protected function validateEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Email is invalid', 400);
        } else if (strlen($email) > 255) {
            throw new Exception('Email is too long', 400);
        }
    }

    protected function validatePassword($password)
    {
        if (strlen($password) <= 0) {
            throw new Exception('Password is invalid', 400);
        }
    }
}
