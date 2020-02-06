
<?php
include_once('../../Domain Layer/models/User.php');

interface IUserRepository
{
    public function GetById(int $id);
    public function GetByEmail(string $email);
    public function AddUser(User $user);
}
?> 
  