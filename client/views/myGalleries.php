<!DOCTYPE html>
<html lang="bg">

<head>
    <title>PHP Gallery</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../resources/css/style.css">
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

    <div class="galleryContainer">
        <?php
        $myGalleries = $galleryRepository->GetLoggedUserGalleries($authorizationService->getLoggedInUser());
        foreach ($myGalleries as $gallery) {
            $topImage = $imageRepository->GetTopImageForGallery($gallery->id);
            $imagePath = ($topImage->id != null ) ? '../../images/' . $topImage->name : '../assets/missingImage.jpg';
            echo '
            <div style="display: inline-block;">
                <div onclick="openGallery(' . $gallery->id . ')" style="height:200px; width:300px; background-size: contain; background-repeat: no-repeat; background-image: url(' . $imagePath . ');"></div>
                <div class="imageInfo">
                    <button onclick="deleteGallery(' . $gallery->id . ')">X</button>
                    <button onclick="toggleGalleryType(' . $gallery->id . ')">' . $gallery->GetType() . '</button>
                    <h3>' . $gallery->name . '</h3>
                    <p>' . $gallery->timestamp . '</p>
                </div>
            </div>
            ';
        }
        ?>
        <div style="display: inline-block;">
            <div onclick="toggleTextInput()" style="height:280px; width:250px; background-size: contain; background-repeat: no-repeat; background-image: url(../assets/createGallery.jpg)">
            </div>
            <div id="galleryInfo" style="display: none">
                <input type="text" name="galleryName" id="galleryNameInput">
                <button onclick="createGallery()" type="submit">Create</button>
                <button onclick="toggleTextInput()" type="submit">Close</button>
            </div>
        </div>

    </div>

    <script>
        function toggleTextInput() {
            let status = document.getElementById("galleryInfo").style.display;
            document.getElementById("galleryInfo").style.display = status === "none" ? "inline-block" : "none";
        }
    </script>
</body>

</html>