<?php
include_once('../../Data Layer/repositories/UserRepository.php');


class LoginPerformerService
{   
    function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function getLoggedUser($loginDto)
    {   
        $user = ($this->userRepository)->GetByEmail($loginDto->email);
        if ($user->id == null) {
            throw new Exception("Invalid credentials. No such email registered.", 400);
        }

        $dbPassword = $user->password;
        if(!password_verify($loginDto->password, $dbPassword)) {
            throw new Exception("Invalid credentials. Password is incorrect.", 400);
        }

        return $user;
    }
}
