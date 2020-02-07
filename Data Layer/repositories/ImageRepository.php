<?php

include('../../Domain Layer/design/IImageRepository.php');
include_once(__DIR__ . '/../DatabaseContext.php');

class ImageRepository extends DatabaseContext implements IImageRepository
{
    public function __construct()
    {
        $this->connection = $this->getConnection();
    }

    public function Save($savedImageName, $imageDescription, $authorId)
    {
        $query = "INSERT INTO php_gallery.images (name, description, userId) VALUES (?,?,?);";

        $statement = $this->connection->prepare($query);
       
        $statement->bind_param('ssi', $savedImageName, $imageDescription, $authorId);
        $statement->execute();
    }

    public function GetImages()
    {
        $query = "SELECT * FROM php_gallery.images";
        $result = $this->connection->query($query);
        // $statement = $this->connection->prepare($query);
        // $statement->execute();
        // $result = mysqli_stmt_get_result($statement);;

       $images = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $images;
    }
}
