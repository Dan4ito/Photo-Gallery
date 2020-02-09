<?php
include('../../Domain Layer/design/IImageRepository.php');
include_once(__DIR__ . '/../DatabaseContext.php');

class ImageRepository extends DatabaseContext implements IImageRepository
{
    public function __construct()
    {
        $this->connection = $this->getConnection();
    }

    public function Save(string $savedImageName, string $imageDescription, int $authorId)
    {
        $query = "INSERT INTO php_gallery.images (name, description, userId) VALUES (?,?,?);";

        $statement = $this->connection->prepare($query);
        $statement->bind_param('ssi', $savedImageName, $imageDescription, $authorId);
        $statement->execute();

        return $this->connection->insert_id;
    }

    public function GetImages()
    {
        $query = "SELECT * FROM php_gallery.images";
        $result = $this->connection->query($query);

        $images = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $images;
    }

    public function GetImagesForGallery(int $galleryId)
    {
        $query = "SELECT * FROM php_gallery.image_gallery a
                    JOIN images i ON a.imageId = i.id 
                    WHERE galleryId =?";         // junktion table

        $statement = $this->connection->prepare($query);
        $statement->bind_param('s', $galleryId);
        $statement->execute();

        $results = $statement->get_result();


        $images = mysqli_fetch_all($results, MYSQLI_ASSOC);

        return $images;
    }
}
