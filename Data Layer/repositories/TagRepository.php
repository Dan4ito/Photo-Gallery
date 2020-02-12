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
}
