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

        $result = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $user = new User($result['id'], $result['username'], $result['email'], $result['password'], $result['roleId']);

        return $user;
    }

    public function GetByEmail(string $email)
    {

        $query = 'SELECT email, username, password, id, roleId
                  FROM users WHERE email =?';

        $statement = $this->connection->prepare($query);
        $statement->bind_param('s', $email);
        $statement->execute();
        $result = mysqli_stmt_get_result($statement);

        $result = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $user = new User($result['id'], $result['username'], $result['email'], $result['password'], $result['roleId']);

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

        return $this->connection->insert_id;
    }
}
