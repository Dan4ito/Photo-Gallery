<?php

include_once('../../Data Layer/repositories/ImageRepository.php');

class SortingService 
{
    private $imageRepository;

    public function __construct()
    {
        $this->imageRepository = new ImageRepository();

    }
 
    public function sortImages($galleryId, $type) 
    {
        $images = $this->imageRepository->GetImagesForGallery($galleryId);   
    
        $imagesIds = array();
        foreach ($images as $image) {
            $imagesIds += array($image->id => $image);
        }

        $imagesTime = array();
        foreach ($images as $image) {
            $time = strval($image->timestamp);
            $imagesTime += array($image->id => $time);
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
        foreach ($imagesTime as $id => $time) {
            array_push($images, $id);
        }

        $sortedImages = array();
        foreach ($images as $arrId => $imageId) {
            array_push($sortedImages, $imagesIds[$imageId]);
        }

        return $sortedImages;
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