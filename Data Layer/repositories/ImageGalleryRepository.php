<?php
include_once('../../Domain Layer/design/IImageGalleryRepository.php');
include_once(__DIR__ . '/../DatabaseContext.php');

class ImageGalleryRepository extends DatabaseContext implements IImageGalleryRepository
{

    public function __construct()
    {
        $this->connection = $this->getConnection();
    }

    public function Create(int $imageId, int $galleryId)
    {
        $query = "INSERT INTO php_gallery.image_gallery (imageId, galleryId) VALUES (?,?);";

        $statement = $this->connection->prepare($query);
        $statement->bind_param('ii', $imageId, $galleryId);
        $statement->execute();

        return $this->connection->insert_id;
    }
}
