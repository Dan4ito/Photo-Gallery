    <!DOCTYPE html>
<html lang="bg">

<head>
    <title>PHP Gallery</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../resources/css/style.css">
    <link rel="stylesheet" href="../resources/css/displayGallery.css">
    <script type="text/javascript" src="../resources/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="../resources/js/script.js"></script>
</head>

<body>
    <?php
    include_once('../../Domain Layer/services/CookieService.php');
    include_once('../../Domain Layer/services/AuthorizationService.php');
    include_once('../../Data Layer/repositories/GalleryRepository.php');
    $cookieService = new CookieService();

    if (!$cookieService->isCookieValid()) {
        header('Location: ' . '.\\login.php');
    }
    $galleryRepository = new GalleryRepository();
    $authorizationService = new AuthorizationService();
    ?>
    <?php include '../components/navbar.php' ?>

    <div class="galleryContainer">
        <?php
        $publicGalleries = $galleryRepository->GetPublicGalleries();
        
        if(count($publicGalleries) == 0) {
            echo '
                <div class="emptyGallery">
                    <p class="imageInfo">
                        There are no public galleries yet. 
                    </p> 
                    <img id="emptyImage" src="../assets/'. 'emptyGallery.png' . '">
                </div>
            ';
        }

        foreach ($publicGalleries as $gallery) {
            echo '
            <div class="galleryDisplay">
                <img onclick="openGallery(' . $gallery->id . ')" id="imageToBeExpanded" src="../assets/' . 'missingImage.jpg' . '">
                <div class="imageInfo">
                    <h3>' . $gallery->name . '</h3>
                    <p>' . $gallery->timestamp . '</p>
                </div>
            </div>
            ';
        }
        ?>
    </div>
</body>

</html>