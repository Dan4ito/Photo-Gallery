<?php

include_once('../../Domain Layer/models/User.php');
include_once('../../Domain Layer/design/IUserRepository.php');
include(__DIR__ . '/../DatabaseContext.php');

class UserRepository extends DatabaseContext implements IUserRepository
{

    public function __construct()
    {
        $this->connection = $this->getConnection();
    }

    public function GetById(int $id)
    {
        $query = 'SELECT email, username, password, user_id, roleId
            FROM users WHERE user_id =:id';

        $statement = $this->connection->prepare($query);
        $statement->bindParam(":id", $id);
        // add password check
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        $email = $row['email'];
        $username = $row['username'];
        $password = $row['password'];
        $roleId = $row['roleId'];
        $user_id = $row['user_id'];

        // $this->connection->close(); close connection sometime?

        $user = new User($username, $email, $password);
        $user->id = $user_id;
        $user->roleId = $roleId;

        return $user;
    }

    public function GetByEmail(string $email)
    {
        $query = 'SELECT email, username, password, user_id, roleId
            FROM users WHERE email =:email';



        $statement = $this->connection->prepare($query);
        $statement->bindParam(":email", $email);
        // add password check
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        $email = $row['email'];
        $username = $row['username'];
        $password = $row['password'];
        $roleId = $row['roleId'];
        $user_id = $row['user_id'];

        // $this->connection->close(); close connection sometime?

        $user = new User($username, $email, $password);
        $user->id = $user_id;
        $user->roleId = $roleId;
        return $user;
    }

    public function AddUser(User $user)
    {
        $query = "INSERT INTO php_gallery.users (email, username, password, roleId)
                  VALUES (:email, :username, :password, :roleId)";
        $statement = $this->connection->prepare($query);

        $statement->bindParam(":email", $user->email);
        $statement->bindParam(":username", $user->username);
        $statement->bindParam(":password", $user->password);
        $user->roleId = 1;      // no one is admin atm
        $statement->bindParam(":roleId", $user->roleId);
        $statement->execute();
    }
}
