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

    public function GetTag(string $tagName)
    {
        $query = 'SELECT * FROM php_gallery.tags 
        WHERE tag = ?';

        $statement = $this->connection->prepare($query);
        $statement->bind_param('s', $tagName);

        $statement->execute();

        $results = $statement->get_result();

        $tag = mysqli_fetch_array($results, MYSQLI_ASSOC);

        return new Tag($tag['id'], $tag['tag']);
    }

    public function CreateTagIfMissing(string $tagName)
    {
        $query = 'INSERT INTO php_gallery.tags (tag) 
        SELECT * FROM (SELECT ?) AS tmp 
        WHERE NOT EXISTS ( SELECT tag FROM php_gallery.tags WHERE tag = ? ) LIMIT 1 ';

        $statement = $this->connection->prepare($query);
        $statement->bind_param('ss', $tagName, $tagName);
        $statement->execute();

        return $this->connection->insert_id;
    }
}
