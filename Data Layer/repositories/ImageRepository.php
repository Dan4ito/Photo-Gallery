<?php
include('../../Domain Layer/design/IImageRepository.php');
include('../../Domain Layer/models/Image.php');
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
        $images = array_map(function($image) { return new Image($image['id'], $image['description'], $image['name'], $image['userId'], $image['timestamp']); }, $images);

        return $images;
    }

    public function DeleteImageFromGallery(int $imageId, int $galleryId)
    {
        $query = "DELETE FROM php_gallery.image_gallery
                    WHERE imageId=? AND galleryId =?";         // junktion table

        $statement = $this->connection->prepare($query);
        $statement->bind_param('ii', $imageId, $galleryId);
        $statement->execute();
    }
}
