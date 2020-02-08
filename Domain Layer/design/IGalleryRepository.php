
<?php
include_once('../../Domain Layer/models/User.php');


interface IGalleryRepository
{
    public function Create($galleryName, int $user);
    public function GetLoggedUserGalleries(User $user);
}
?> 
  