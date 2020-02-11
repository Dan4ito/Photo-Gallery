<?php
include_once('../../Domain Layer/design/IImageGalleryRepository.php');
include_once(__DIR__ . '/../DatabaseContext.php');

class ImageTagRepository extends DatabaseContext implements IImageTagRepository
{

    public function __construct()
    {
        $this->connection = $this->getConnection();
    }

    public function Create(int $imageId, int $tagId)
    {
        $query = "INSERT INTO php_gallery.image_gallery (imageId, galleryId) VALUES (?,?);";

        $statement = $this->connection->prepare($query);
        $statement->bind_param('ii', $imageId, $tagId);
        $statement->execute();

        return $this->connection->insert_id;
    }

    // public function InsertImagesForGallery($imageIds, int $galleryId)
    // {
    //     $query = "INSERT INTO php_gallery.image_gallery (imageId, galleryId) VALUES ";

    //     $imagesIdsCount = count($imageIds);
    //     $clauseToAppend = null;
    //     for ($i = 0; $i < $imagesIdsCount; $i++) {
    //         $clauseToAppend = "(" . $imageIds[$i] . ", " . $galleryId . ")";
    //         if ($i != $imagesIdsCount - 1) {
    //             $clauseToAppend .= ", ";
    //         }
    //         $query .= $clauseToAppend;
    //     }

    //     $result = mysqli_query($this->connection, $query);
    // }
}
