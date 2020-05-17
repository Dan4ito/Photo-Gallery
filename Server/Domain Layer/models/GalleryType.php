<?php
class GalleryType
{
    public $id;
    public $type;


    public function __construct(int $id = null, string $type = null)
    {
        $this->id = $id;
        $this->type = $type;
    }
}
