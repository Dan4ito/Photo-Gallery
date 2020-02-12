<?php
include_once('../../Domain Layer/design/ITagRepository.php');
include_once('../../Domain Layer/models/Tag.php');
include_once(__DIR__ . '/../DatabaseContext.php');

class TagRepository extends DatabaseContext implements ITagRepository
{
    public function __construct()
    {
        $this->connection = $this->getConnection();
    }

    public function Save($tag) 
    {
        $query = 'INSERT INTO php_gallery.tags (tag) VALUES ';
        $statement = $this->connection->prepare($query);
        $statement->bind_param('s', $tag);
        $statement->execute();

        return $this->connection->insert_id;
    }

    public function GetAllTags()
    {
        $query = 'SELECT * FROM php_gallery.tags';
        $results = mysqli_query($this->connection, $query);
        $tags = mysqli_fetch_all($results, MYSQLI_ASSOC);
        $tags = array_map(function ($tag) {
            return new Tag($tag['id'], $tag['tag']);
        }, $tags);

        return $tags;
    }

    public function GetIdByName($tag) 
    {
        $query = 'SELECT id FROM php_tags WHERE tag=?';
        $statement = $this->connection->prepare($query);
        $statement->bind_param('s', $tag);
        $statement->execute();
        $result = $statement->get_result();
        $tagId = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $tagId; 
    }

    public function GetAllTagsForImage(int $imageId)
    {
        $query = "SELECT * FROM php_gallery.image_tag it
                    JOIN tags t on t.id = it.tagId
                    WHERE it.imageId =?";
        $statement = $this->connection->prepare($query);
        $statement->bind_param('i', $imageId);
        $statement->execute();
        $results = $statement->get_result();

        $tags = mysqli_fetch_all($results, MYSQLI_ASSOC);
        $tags = array_map((function ($tag) {
            return new Tag($tag['id'], $tag['tag']);
        }), $tags);

        return $tags;
    }
}
