<?php

class SortingService 
{
public function sortImages($images, $type) 
{
    foreach ($images as $image) {
        $imagesTime[$image] = strval($image->timestamp);
    }
    $sort = $this->getSortType($type);
    if($sort == "asc")
    {
        asort($imagesTime);
    }
    if($sort == "desc")
    {
        arsort($imagesTime);  
    }
    $images = array();
    foreach ($images as $image => $time) {
        array_push($images, $image);
    }
    return $images;
}

private function getSortType($sort) 
{
    $asc = ["asc", "ascending"];
    $desc = ["desc", "descending"];

    if(in_array($sort, $asc)) 
    {
        $type = "asc";
    }

    if(in_array($sort, $desc)) 
    {
        $type = "desc";
    }
    return $type;
}

}
?>