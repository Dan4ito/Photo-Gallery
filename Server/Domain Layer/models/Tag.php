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

    public static function GetId(string $tag)
    {
        switch ($tag) {
            case Tags::KITTENS:
                Tags::KITTENS_VALUE;
                break;
            case Tags::GAMES:
                Tags::GAMES_VALUE;
                break;
            case Tags::NATURE:
                Tags::NATURE;
                break;
            default:
                throw new Exception("Tag not present in application enum");
        }
    }
}
