
<?php
include_once('../../Domain Layer/models/User.php');

interface IGalleryRepository
{
    public function Create(string $galleryName, int $userId);
    public function DeleteGallery(int $galleryId);
    public function GetById(int $galleryId);
    public function GetByIds($galleryIds);
    public function ToggleGalleryType(int $galleryId);
    public function GetLoggedUserGalleries(User $user);
    public function GetPublicGalleries();
}
?> 
  