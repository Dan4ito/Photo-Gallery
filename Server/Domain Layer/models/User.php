<?php
class User
{
    public $id;
    public $username;
    public $email;
    public $password;
    public $roleId;


    public function __construct(int $id = null, string $username = null, string $email = null, string $password = null, int $roleId = null)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->roleId = $roleId;
    }
}
