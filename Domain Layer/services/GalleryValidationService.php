<?php
class GalleryValidationService
{

    public function validateGallery($galleryName)
    {
        if (empty($galleryName)) {
            throw new Exception("Missing gallery name!", 400);
        }
    }
}
