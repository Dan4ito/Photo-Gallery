<!DOCTYPE html>
<html lang="en">

<head>
    <title>PHP Gallery</title>
    <meta charset="UTF-8">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i&display=swap&subset=cyrillic,cyrillic-ext" rel="stylesheet">
    <link rel="stylesheet" href="../resources/css/style.css">
    <link rel="stylesheet" href="../resources/css/formsOutline.css">
    <link rel="stylesheet" href="../resources/css/displayGallery.css">
    <link rel="stylesheet" href="../resources/css/polaroidGallery.css">
    <link rel="stylesheet" href="../resources/css/filterGallery.css">

    <script type="text/javascript" src="../resources/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="../resources/js/script.js"></script>
    <script type="text/javascript" src="../resources/js/displayGallery.js"></script>
</head>

<body>
    <?php
    include_once('../../Domain Layer/services/CookieService.php');
    include_once('../../Domain Layer/services/UrlService.php');
    include_once('../../Domain Layer/services/GalleryUserValidatorService.php');
    include_once('../../Data Layer/repositories/ImageRepository.php');
    include_once('../../Data Layer/repositories/GalleryRepository.php');

    $galleryUserValidatorService = new GalleryUserValidatorService();
    $cookieService = new CookieService();
    $urlService = new UrlService();

    $galleryId = $urlService->GetQueryParam("id");

    if (!$cookieService->isCookieValid() || !$galleryUserValidatorService->canUserViewGallery($galleryId)) {
        header('Location: ' . '.\\login.php');
    }

    $galleryRepository = new GalleryRepository();
    $imageRepository = new ImageRepository();

    ?>
    <?php include '../components/navbar.php' ?>

    <div class="options">
        <?php
            $gallery = $galleryRepository->GetById($galleryId);
            $id = $gallery->id;
            echo '
                <input class="filter" id="filterDescription" type="text" placeholder="Filter images by tag" name="filter">
                <button class="optionsButton" onclick="filterImages(' . $id . ')">Filter</button>
                <input class="filter" id="sortImages" type="text" placeholder="Sort images by date ascending or descending" name="sort">
                <button class="optionsButton" id="sort" onclick="sortImages(' . $id . ')">Sort</button>
                
                <button class="optionsButton" id="move" onclick="moveImages(' . $id . ')">Move to</button>
                <button class="optionsButton" id="select" onclick="selectImages(' . $id . ')">Select</button>
            ';
        ?>
    </div>

    <div class="galleryUpload">
        <form class="formUpload" action="" method="post" enctype="multipart/form-data">
            <h1>Upload file</h1>
            <label for="image">Description</label>
            <input id="imageDescriptionInput" type="text" name="fileDescription" placeholder="Image description...">

            <label for="image">Image</label>
            <input id="fileInput" type="file" name="file">

            <label for="resize">% compression*</label>
            <input id="resize" type="number" min="0" max="100" placeholder="Compression % (Optional)">

            <button class="logButton" onclick="uploadImage(<?php echo $urlService->GetQueryParam('id') ?>)">Upload</button>
        </form>
    </div>

    <div class="galleryContainer">
        <?php
        $gallery = $galleryRepository->GetById($galleryId);
        $images = $imageRepository->GetImagesForGallery($galleryId);
        $i = 0;

        foreach ($images as $image) {
            $description = $image->description; //str_replace(" ", "+", $image->description);
            $time = $image->timestamp; //str_replace(" ", "+", );
            echo '
            <div class="row">
                <button class="deleteButton" onclick="deleteImageFromGallery(' . $image->id . ',' . $gallery->id . ')" onmouseover="highlightImage(' . $i . ')" onmouseout="normalizeImage(' . $i . ')">&times;</button>
                <img src="../../images/' . $image->name . '" class ="images" alt = ' . $time . ' title = ' . $description . ' onclick="expandImage(this, ' . $i . ')" onmouseover="highlightImage(' . $i . ')" onmouseout="normalizeImage(' . $i . ')";>
                <div class="imageInfo">
                    <h3>' . $image->description . '</h3>
                    <p>' . $image->timestamp . '</p>
                </div>
            </div>
            ';
            $i++;
        }
        ?>
    </div>

    <div id="polaroid">
        <span class="closeButton">&times;</span>
        <a class="prev" onclick="changeSlide(-1)">&laquo;</a>
        <a class="next" onclick="changeSlide(1)">&raquo;</a>
        <div id="wrapper">
            <img id="expandedImage">
            <div class="caption">
                <p id="captionDescription"></p>
                <p id="captionTime"></p>
            </div>
        </div>
        <div class="previews">
            <?php
            $gallery = $galleryRepository->GetById($galleryId);
            $images = $imageRepository->GetImagesForGallery($galleryId);
            $i = 1;
            foreach ($images as $image) {
                $description = str_replace(" ", "+", $image->description);
                $time = str_replace(" ", "+", $image->timestamp);
                echo '
                    <div class="previewRow">
                        <img src="../../images/' . $image->name . '" class="preview images" alt = ' . $time . ' title = ' . $description . ' onclick="currentSlide(' . $i . ')";>
                    </div>
                    ';
                $i++;
            }
            ?>
        </div>
    </div>
</body>

</html>