<?php
class LoginDto
{
    public $email;
    public $password;

    function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }
    function get_email()
    {
        return $this->email;
    }
    function get_password()
    {
        return $this->password;
    }
}
