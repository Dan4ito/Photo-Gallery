<?php
include_once('../../Domain Layer/models/Gallery.php');
include_once('../../Domain Layer/design/IGalleryRepository.php');
include_once('../../Domain Layer/enums/GalleryTypes.php');
include_once(__DIR__ . '/../DatabaseContext.php');

class GalleryRepository extends DatabaseContext implements IGalleryRepository
{

    public function __construct()
    {
        $this->connection = $this->getConnection();
    }

    public function GetLoggedUserGalleries(User $user)
    {
        $query = "SELECT * FROM php_gallery.galleries
                  WHERE userId =?";

        $statement = $this->connection->prepare($query);
        $statement->bind_param('i', $user->id);
        $statement->execute();
        $results = $statement->get_result();


        $galleries = mysqli_fetch_all($results, MYSQLI_ASSOC);
        $galleries = array_map(function ($gallery) {
            return new Gallery($gallery['id'], $gallery['name'], $gallery['timestamp'], $gallery['userId'], $gallery['typeId']);
        }, $galleries);
        return $galleries;
    }

    public function Create(string $galleryName, int $userId)
    {
        $query = "INSERT INTO php_gallery.galleries (name, userId) VALUES (?,?);";

        $statement = $this->connection->prepare($query);
        $statement->bind_param('si', $galleryName, $userId);
        $statement->execute();

        return $this->connection->insert_id;
    }

    public function DeleteGallery(int $galleryId)
    {
        $query = "DELETE FROM php_gallery.galleries WHERE id = ?";

        $statement = $this->connection->prepare($query);
        $statement->bind_param('i', $galleryId);
        $statement->execute();
    }

    public function GetById(int $galleryId)
    {
        $query = "SELECT * FROM php_gallery.galleries
        WHERE id =?";

        $statement = $this->connection->prepare($query);
        $statement->bind_param('i', $galleryId);
        $statement->execute();

        $results = $statement->get_result();
        $gallery = mysqli_fetch_array($results, MYSQLI_ASSOC);

        return new Gallery($gallery['id'], $gallery['name'], $gallery['timestamp'], $gallery['userId'], $gallery['typeId']);
    }

    public function GetPublicGalleries()
    {
        $query = "SELECT g.* FROM php_gallery.galleries g
                    JOIN galleryTypes t ON g.typeId = t.id 
                    WHERE t.type =?";

        $statement = $this->connection->prepare($query);
        $publicType = GalleryTypes::PUBLIC;
        $statement->bind_param('s', $publicType);
        $statement->execute();
        $results = $statement->get_result();

        $publicGalleries = mysqli_fetch_all($results, MYSQLI_ASSOC);
        $publicGalleries = array_map(function ($gallery) {
            return new Gallery($gallery['id'], $gallery['name'], $gallery['timestamp'], $gallery['userId'], $gallery['typeId']);
        }, $publicGalleries);
        return $publicGalleries;
    }

    public function ToggleGalleryType(int $galleryId)
    {
        $query = "UPDATE php_gallery.galleries g 
                    SET g.typeId = CASE 
                                    WHEN g.typeId = 1 then 2
                                    WHEN g.typeId = 2 then 1
                                    END
                    WHERE g.id = ?";

        $statement = $this->connection->prepare($query);
        $statement->bind_param('i', $galleryId);
        $statement->execute();
    }
}
