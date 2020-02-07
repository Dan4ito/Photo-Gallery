<?php

include_once('../../Domain Layer/models/User.php');
include_once('../../Domain Layer/design/IUserRepository.php');
include_once(__DIR__ . '/../DatabaseContext.php');

class UserRepository extends DatabaseContext implements IUserRepository
{

    public function __construct()
    {
        $this->connection = $this->getConnection();
    }

    public function GetById(int $id)
    {
        $query = 'SELECT email, username, password, id, roleId
        FROM users WHERE id =?';
      
        $statement = $this->connection->prepare($query);
        $statement->bind_param('i', $id);
        $statement->execute();
        $result = mysqli_stmt_get_result($statement);;

        $row = mysqli_fetch_array($result, MYSQLI_NUM);
        $email = $row[0];
        $username = $row[1];
        $password = $row[2];
        $roleId = $row[4];
        $user_id = $row[3];

        $user = new User($username, $email, $password);
        $user->id = $user_id;
        $user->roleId = $roleId;

        return $user;  
    }

    public function GetByEmail(string $email)
    {

        $query = 'SELECT email, username, password, id, roleId
                  FROM users WHERE email =?';

        $statement = $this->connection->prepare($query);
        $statement->bind_param('s', $email);
        $statement->execute();
        $result = mysqli_stmt_get_result($statement);;

        $row = mysqli_fetch_array($result, MYSQLI_NUM);
        $email = $row[0];
        $username = $row[1];
        $password = $row[2];
        $roleId = $row[4];
        $user_id = $row[3];

        $user = new User($username, $email, $password);
        $user->id = $user_id;
        $user->roleId = $roleId;

        return $user;    
    }

    public function AddUser(User $user)
    {
        $query = "INSERT INTO php_gallery.users (email, username, password, roleId)
                  VALUES (?, ?, ?, ?)";

        $statement = $this->connection->prepare($query);
        $user->roleId = 1; // no one is admin atm
        $statement->bind_param('sssi', $user->email, $user->username, $user->password, $user->roleId);
        $statement->execute();
    }
}
