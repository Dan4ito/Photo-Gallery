<!DOCTYPE html>
<html lang="en">

<head>
    <title>PHP Gallery</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="icon" href="../assets/icon.png"/>
    <link rel="stylesheet" href="../resources/css/style.css">
    <link rel="stylesheet" href="../resources/css/listGallery.css">
    <link rel="stylesheet" href="../resources/css/formsOutline.css">
    <link rel="stylesheet" href="../resources/css/flexGallery.css">
    <script type="text/javascript" src="../resources/js/script.js"></script>
    <script type="text/javascript" src="../resources/js/utils.js"></script>
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

    $config = require('../../AWS/config.php');
    $imageLocation = 'https://' . $config['s3']['bucket'] . '.s3.amazonaws.com/';
    
    $galleryRepository = new GalleryRepository();
    $authorizationService = new AuthorizationService();
    $imageRepository = new ImageRepository();
    ?>
    <?php include '../components/navbar.php' ?>
    <div id="createGallery">
        <button onclick="toggleForm(galleryCreateDiv)">+ new</button>
    </div>
    <div id="galleryCreateDiv" class="overlayDiv">
        <button id="closeGalleryFormButton" onclick="toggleForm(galleryCreateDiv)">X</button>
        <form id="galleryCreateForm">
            <img class="create" id="imageToBeExpanded" src="../assets/createGallery.jpg">
            <div>  
                <input type="text" name="galleryName" id="galleryNameInput" placeholder="Gallery name">
                <button class="newGalleryButton" id="create" onclick="createGallery()" type="submit">Create</button>
            </div>
        </div>
    </div>
    <div class="galleriesContainer galleryFlexContainer">
        <?php
        $myGalleries = $galleryRepository->GetLoggedUserGalleries($authorizationService->getLoggedInUser());
        foreach ($myGalleries as $gallery) {
            $topImage = $imageRepository->GetTopImageForGallery($gallery->id);
            $imagePath = ($topImage->id != null) ? $imageLocation . $topImage->name : '../assets/missingImage.jpg';
            echo '
                <div class="galleryDisplay galleryFlexItem">
                    <div class="galleryButtons">
                        <button class="galleryTypeChangeButton" onclick="toggleGalleryType(' . $gallery->id . ')">' . $gallery->GetType() . '</button>
                        <button class="deleteButton" onclick="deleteGallery(' . $gallery->id . ')">&times;</button>    
                    </div>
                    
                    <div class="galleryImg galleryFlexImg">
                        <img onclick="openGallery(' . $gallery->id . ')" id="galleryImageToBeDisplayed" src="' . $imagePath . '">
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

    <script>
        toggleTextInput = () => {
            let status = document.getElementById("galleryInfo").style.visibility;
            document.getElementById("galleryInfo").style.visibility = (status == "hidden" || status == "") ? "visible" : "hidden";
        }
    </script>
</body>

</html>