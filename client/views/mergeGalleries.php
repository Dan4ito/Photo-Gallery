<!DOCTYPE html>
<html lang="bg">

<head>
    <title>PHP Gallery</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="icon" href="../assets/icon.png"/>
    <link rel="stylesheet" href="../resources/css/style.css">
    <link rel="stylesheet" href="../resources/css/flexGallery.css">
    <link rel="stylesheet" href="../resources/css/formsOutline.css">
    <link rel="stylesheet" href="../resources/css/mergeGalleries.css">
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

    <?php echo '    
    <div class="galleryCreate">
        <div id="galleryInfo">
            <input type="text" name="galleryName" id="galleryNameInput" placeholder="Gallery name">
            <button class="galleryButton" id="create" onclick="sendMergeGalleriesRequest()" type="submit">+ Merge</button>
        </div>
    </div>' ?>
    <div class="galleriesContainer galleryFlexContainer">
        <?php
        $myGalleries = $galleryRepository->GetLoggedUserGalleries($authorizationService->getLoggedInUser());
        $publicGalleries = $galleryRepository->GetPublicGalleries();
        $otherPeoplePublicGalleriesWithoutYours = array_udiff($publicGalleries, $myGalleries, function ($obj_a, $obj_b) {
            return $obj_a->id - $obj_b->id;
        });   // because some of yours may also be public
        $allVisibleGalleriesForYou = array_merge($myGalleries, $otherPeoplePublicGalleriesWithoutYours);
        foreach ($allVisibleGalleriesForYou as $gallery) {
            $topImage = $imageRepository->GetTopImageForGallery($gallery->id);
            $imagePath = ($topImage->id != null) ? '../../images/' . $topImage->name : '../assets/missingImage.jpg';
            echo '
            <div class="galleryDisplay galleryFlexItem">
                <div class="galleryFlexImg">
                    <img onclick="toggleGallery(' . $gallery->id . ', this)" id="galleryImageToBeDisplayed" src="' . $imagePath . '">
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
        let selectedGalleries = [];
        toggleGallery = (selectedGalleryId, selected) => {
            if (!selectedGalleries.includes(selectedGalleryId)) {
                selectedGalleries.push(selectedGalleryId);
                selected.classList.add("selected");
            } else {
                selectedGalleries.splice(selectedGalleries.indexOf(selectedGalleryId), 1);
                selected.classList.remove("selected");
            }
            console.log(selectedGalleries);
        }
        sendMergeGalleriesRequest = () => {
            if (selectedGalleries.length < 2) alert("You must select more at least two galleries for merge!")
            else {
                mergeGalleries(selectedGalleries);
            }
        }

        toggleTextInput = () => {
            let status = document.getElementById("galleryInfo").style.visibility;
            document.getElementById("galleryInfo").style.visibility = (status == "hidden" || status == "") ? "visible" : "hidden";
        }
    </script>
</body>

</html>