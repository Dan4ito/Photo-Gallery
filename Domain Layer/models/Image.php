<?php
class Image
{
    public $id;
    public $description;
    public $name;
    public $userId;
    public $timestamp;
    public $imageTags;
    


    public function __construct(int $id = null, string $description = null, string $name = null, int $userId = null, string $timestamp = null, $imageTags = null)
    {
        $this->id = $id;
        $this->description = $description;
        $this->name = $name;
        $this->userId = $userId;
        $this->timestamp = $timestamp;
        $this->imageTags = $imageTags;
    }
}
