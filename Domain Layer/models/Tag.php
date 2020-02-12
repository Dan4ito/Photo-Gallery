<?php
class Tag
{
    public $id;
    public $tag;


    public function __construct(int $id = null, string $tag = null)
    {
        $this->id = $id;
        $this->tag = $tag;
    }
}
