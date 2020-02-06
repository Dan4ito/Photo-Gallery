<?php
class User
{
    public $id;
    public $username;
    public $email;
    public $password;
    public $roleId;


    public function __construct($username = null, $email = null, $password = null)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }
}
