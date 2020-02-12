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

    public function Save(string $savedImageName, string $imageDescription, int $authorId, string $timestamp = "")
    {
        if($timestamp == "") 
        {
            $query = "INSERT INTO php_gallery.images (name, description, userId) VALUES (?,?,?);";
        }
        else 
        {
            $query = "INSERT INTO php_gallery.images (name, description, userId, timestamp) VALUES (?,?,?,?);";
        }

        $statement = $this->connection->prepare($query);

        if($timestamp == "") 
        {
            $statement->bind_param('ssi', $savedImageName, $imageDescription, $authorId);        
        }
        else 
        {
            $statement->bind_param('ssis', $savedImageName, $imageDescription, $authorId, $timestamp);
        }
        $statement->execute();

        return $this->connection->insert_id;
    }

    public function GetTopImageForGallery(int $galleryId)
    {
        $query = "SELECT * FROM php_gallery.image_gallery a 
                    JOIN images i ON a.imageId = i.id 
                    WHERE galleryId = ?  ORDER BY i.timestamp ASC LIMIT 1";

        $statement = $this->connection->prepare($query);
        $statement->bind_param('i', $galleryId);
        $statement->execute();

        $result = $statement->get_result();


        $topImage = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $topImage = new Image($topImage['id'], $topImage['description'], $topImage['name'], $topImage['userId'], $topImage['timestamp']);

        return $topImage;
    }

    public function GetImagesForGallery(int $galleryId)
    {
        $query = "SELECT * FROM php_gallery.image_gallery a
                    JOIN images i ON a.imageId = i.id 
                    WHERE a.galleryId =?";         // junktion table

        $statement = $this->connection->prepare($query);
        $statement->bind_param('i', $galleryId);

        $statement->execute();

        $results = $statement->get_result();
    
        $images = mysqli_fetch_all($results, MYSQLI_ASSOC);
        $images = array_map(function ($image) {
            return new Image($image['id'], $image['description'], $image['name'], $image['userId'], $image['timestamp']);
        }, $images);

        return $images;
    }

    public function GetImagesForGalleries($galleryIds)
    {
        $query = "SELECT * FROM php_gallery.image_gallery a
                    JOIN images i ON a.imageId = i.id 
                    WHERE"; // galleryId =?";         // junktion table

        $galleryIdsCount = count($galleryIds);
        $clauseToAppend = null;
        for ($i = 0; $i < $galleryIdsCount; $i++) {
            if ($i != $galleryIdsCount - 1) {
                $clauseToAppend = " galleryId =" . $galleryIds[$i] . " OR";
            } else {
                $clauseToAppend = " galleryId =" . $galleryIds[$i];
            }
            $query .= $clauseToAppend;
        }

        $results = mysqli_query($this->connection, $query);

        $images = mysqli_fetch_all($results, MYSQLI_ASSOC);

        $images = array_map(function ($image) {
            return new Image($image['id'], $image['description'], $image['name'], $image['userId'], $image['timestamp']);
        }, $images);

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
