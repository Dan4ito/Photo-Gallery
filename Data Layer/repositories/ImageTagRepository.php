<?php
include_once('../../Domain Layer/design/IImageTagRepository.php');
include_once('../../Domain Layer/enums/Tags.php');
include_once(__DIR__ . '/../DatabaseContext.php');

class ImageTagRepository extends DatabaseContext implements IImageTagRepository
{

    public function __construct()
    {
        $this->connection = $this->getConnection();
    }

    public function Create(int $imageId, $tagId)
    {
        $query = "INSERT INTO php_gallery.image_tag (imageId, tagId) VALUES (?, ?)";

        $statement = $this->connection->prepare($query);
        $statement->bind_param('ii', $imageId, $tagId);

        $statement->execute();
    }
}
