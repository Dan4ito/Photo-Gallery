<!DOCTYPE html>
<html lang="bg">

<head>
    <title>PHP Gallery</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../resources/css/style.css">
    <link rel="stylesheet" href="../resources/css/displayGallery.css">
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

    <div class="galleriesContainer">
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
            <div class="galleryDisplay">
                <img onclick="toggleGallery(' . $gallery->id . ', this)" id="galleryImageToBeDisplayed" src="' . $imagePath . '">
      
                <div class="imageInfo">
                    <h3>' . $gallery->name . '</h3>
                    <p>' . $gallery->timestamp . '</p>
                </div>
            </div>
            ';
        }
        ?>

    </div>

    <?php echo '    
    <div class="galleryCreate">
        <img onclick="toggleTextInput()" class="create" id="imageToBeExpanded" src="../assets/createGallery.jpg">
        <div id="galleryInfo">
            <input type="text" name="galleryName" id="galleryNameInput" placeholder="Gallery name">
            <button class="galleryButton" id="create" onclick="sendMergeGalleriesRequest()" type="submit">Create</button>
            <button class="galleryButton" id="close" onclick="toggleTextInput()" type="submit">Close</button>
        </div>
    </div>' ?>
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