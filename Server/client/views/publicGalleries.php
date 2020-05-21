    <!DOCTYPE html>
    <html lang="bg">

    <head>
        <title>PHP Gallery</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">  
        
        <link rel="icon" href="../assets/icon.png"/>
        <link rel="stylesheet" href="../resources/css/style.css">
        <link rel="stylesheet" href="../resources/css/flexGallery.css">
        <link rel="stylesheet" href="../resources/css/publicGallery.css">
        <script type="text/javascript" src="../resources/js/script.js"></script>
    </head>

    <body>
        <?php
        include_once('../../Domain Layer/services/CookieService.php');
        include_once('../../Domain Layer/services/AuthorizationService.php');
        include_once('../../Data Layer/repositories/GalleryRepository.php');
        include_once('../../Data Layer/repositories/ImageRepository.php');
        $cookieService = new CookieService();

        if (!$cookieService->isCookieValid()) {
            header('Location: ' . '.\\login.php');
        }
        $galleryRepository = new GalleryRepository();
        $authorizationService = new AuthorizationService();
        $imageRepository = new ImageRepository();

        $config = require('../../AWS/config.php');
        $imageLocation = 'https://' . $config['s3']['bucket'] . '.s3.amazonaws.com/';

        ?>
        <?php include '../components/navbar.php' ?>

        <div class="galleriesContainer galleryFlexContainer">
            <?php
            $publicGalleries = $galleryRepository->GetPublicGalleries();

            if (count($publicGalleries) == 0) {
                echo '
                <div class="emptyGallery">
                    <p class="imageInfo">
                        There are no public galleries yet. 
                    </p> 
                    <div>
                        <img id="emptyImage" src="../assets/' . 'emptyGallery.png' . '">
                    </div>
                </div>
            ';
            }

            foreach ($publicGalleries as $gallery) {
                $topImage = $imageRepository->GetTopImageForGallery($gallery->id);
                $imagePath = ($topImage->id != null) ? $imageLocation . $topImage->name : '../assets/missingImage.jpg';
                echo '
                <div class="galleryDisplay galleryFlexItem">
                    <div class="galleryFlexImg">
                        <img onclick="openGallery(' . $gallery->id . ')" id="imageToBeExpanded" src="'. $imagePath . '">
                    </div>
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