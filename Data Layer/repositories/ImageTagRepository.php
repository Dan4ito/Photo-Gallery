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

    public function Create(int $imageId, $tagIds)
    {
        $query = "INSERT INTO php_gallery.image_tag (imageId, tagId) VALUES ";
        
        $imagesIdsCount = count($tagIds);
        $clauseToAppend = null;
        for ($i = 0; $i < $imagesIdsCount; $i++) {
            $clauseToAppend = "(" . $imageId . ", '" . $tagIds[$i] . "')";
            if ($i != $imagesIdsCount - 1) {
                $clauseToAppend .= ", ";
            }
            $query .= $clauseToAppend;
        }

        $result = mysqli_query($this->connection, $query);

    }
}
