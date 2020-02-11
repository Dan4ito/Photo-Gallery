<!DOCTYPE html>
<html lang="en">

<head>
    <title>PHP Gallery</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../resources/css/style.css">
    <link rel="stylesheet" href="../resources/css/displayGallery.css">
    <link rel="stylesheet" href="../resources/css/formsOutline.css">
    <script type="text/javascript" src="../resources/js/jquery-3.3.1.min.js"></script>
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
    ?>
    <?php include '../components/navbar.php' ?>

    <div class="galleriesContainer">

        <?php
        $myGalleries = $galleryRepository->GetLoggedUserGalleries($authorizationService->getLoggedInUser());
        foreach ($myGalleries as $gallery) {
            $topImage = $imageRepository->GetTopImageForGallery($gallery->id);
            $imagePath = ($topImage->id != null) ? '../../images/' . $topImage->name : '../assets/missingImage.jpg';
            echo '
                <div class="galleryDisplay">
                    <button class="galleryTypeChangeButton" onclick="toggleGalleryType(' . $gallery->id . ')">' . $gallery->GetType() . '</button>
                    <button class="deleteButton" onclick="deleteGallery(' . $gallery->id . ')">&times;</button>    
                    
                    <div class="galleryNode">
                        <img onclick="openGallery(' . $gallery->id . ')" class="galleryImageToBeDisplayed" src="' . $imagePath . '">
                        <div class="imageInfo">
                            <h3>' . $gallery->name . '</h3>
                            <p>' . $gallery->timestamp . '</p>
                        </div>
                    </div>
                </div>
                ';
        }
        ?>

        <div class="galleryCreate">
            <img onclick="toggleTextInput()" class="create" id="galleryImageToBeExpanded" src="../assets/createGallery.jpg">
            <div id="galleryInfo">
                <input type="text" name="galleryName" id="galleryNameInput" placeholder="Gallery name">
                <button class="galleryButton" id="create" onclick="createGallery()" type="submit">Create</button>
                <button class="galleryButton" id="close" onclick="toggleTextInput()" type="submit">Close</button>
            </div>
        </div>
        <a href="mergeGalleries.php"><img src="../assets/merge.jpg" style="width:200px; height:200px"></a>
    </div>

    <script>
        toggleTextInput = () => {
            let status = document.getElementById("galleryInfo").style.visibility;
            document.getElementById("galleryInfo").style.visibility = (status == "hidden" || status == "") ? "visible" : "hidden";
        }
    </script>
</body>

</html>