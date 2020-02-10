<?php

class Gallery
{
    public $id;
    public $name;
    public $timestamp;
    public $userId;
    public $typeId;


    public function __construct(int $id = null, string $name = null, string $timestamp = null, int $userId = null, int $typeId = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->timestamp = $timestamp;
        $this->userId = $userId;
        $this->typeId = $typeId;
    }

    public function GetType(){
        if($this->typeId == GalleryTypes::PRIVATE_VALUE) return "Private";
        else if ($this->typeId == GalleryTypes::PUBLIC_VALUE) return "Public";
        else return "Unknown";
    }
}
