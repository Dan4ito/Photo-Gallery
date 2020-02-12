
<?php

interface ITagRepository
{
    public function GetAllTags();
    public function GetTag(string $tagName);
    public function CreateTagIfMissing(string $tagName);
    
}
?> 
  