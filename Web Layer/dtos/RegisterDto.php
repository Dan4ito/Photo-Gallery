<?php
class RegisterDto
{
    public $username;
    public $email;
    public $password;

    function __construct($username, $email, $password)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }
    function get_username()
    {
        return $this->username;
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
