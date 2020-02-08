
<?php
include_once('../../Domain Layer/models/User.php');


interface IGalleryRepository
{
    public function Create($galleryName, int $userId);
    public function DeleteGallery($galleryId);
    public function GetById($galleryId);
    public function GetLoggedUserGalleries(User $user);
}
?> 
  