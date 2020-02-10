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

    <div class="galleryContainer">
        <?php
        $gallery = $galleryRepository->GetById($galleryId);
        $images = $imageRepository->GetImagesForGallery($galleryId);

        foreach ($images as $image) {
            echo '
            <div style="display: inline-block;">
            <div style="height:200px; width:300px; background-size: contain; background-repeat: no-repeat; background-image: url(../../images/' . $image->name . ');"></div>
            <div class="imageInfo">
                <h3>' . $image->description . '</h3>
                <p>' . $image->timestamp . '</p>
            </div>
            </div>
            ';
        }
        ?>

        <div class="galleryUpload">
            <form action="" method="post" enctype="multipart/form-data">
                <!-- <input type="text" name="fileTitle" placeholder="Image title..."> Tags ? -->
                <input id="imageDescriptionInput" type="text" name="fileDescription" placeholder="Image description...">
                <input id="fileInput" type="file" name="file">
                <button onclick="uploadImage(<?php echo $urlService->GetQueryParam('id') ?>)">Upload</button>
                <!-- <button type="submit" name="submit">Upload</button> -->
            </form>
        </div>


    </div>

</body>

</html>