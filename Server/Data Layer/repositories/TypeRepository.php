<?php
include_once('../../Domain Layer/design/ITypeRepository.php');
include_once('../../Domain Layer/models/GalleryType.php');
include_once(__DIR__ . '/../DatabaseContext.php');

class TypeRepository extends DatabaseContext implements ITypeRepository
{
    public function __construct()
    {
        $this->connection = $this->getConnection();
    }

    public function GetById(int $id)
    {
        $query = 'SELECT *
        FROM galleryTypes WHERE id =?';

        $statement = $this->connection->prepare($query);
        $statement->bind_param('i', $id);
        $statement->execute();
        $result = mysqli_stmt_get_result($statement);;

        $result = mysqli_fetch_array($result, MYSQLI_ASSOC); 

        return new GalleryType($result['id'], $result['type']);
    }
}
