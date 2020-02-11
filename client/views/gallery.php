<!DOCTYPE html>
<html lang="bg">

<head>
    <title>PHP Gallery</title>
    <meta charset="UTF-8">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i&display=swap&subset=cyrillic,cyrillic-ext" rel="stylesheet">
    <link rel="stylesheet" href="../resources/css/style.css">
    <link rel="stylesheet" href="../resources/css/displayGallery.css">

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

    <div class="galleryContainer">
        <?php
        $gallery = $galleryRepository->GetById($galleryId);
        $images = $imageRepository->GetImagesForGallery($galleryId);
        $i = 1;

        $canUserEditGallery = $galleryUserValidatorService->canUserEditGallery($galleryId);
        foreach ($images as $image) {
            $description = str_replace(" ", "+", $image->description);
            $time = str_replace(" ", "+", $image->timestamp);
            echo '
            <div class="row">
                <img src="../../images/' . $image->name . '" id="imageToBeExpanded" class ="images" alt = ' . $time . ' title = ' . $description . ' onclick="expandImage(this, ' . $i . ')";>
                <div class="imageInfo">
                    <h3>' . $image->description . '</h3>
                    <p>' . $image->timestamp . '</p>
                </div>
                ' . ($canUserEditGallery ? ('<button onclick="deleteImageFromGallery(' . $image->id . ',' . $gallery->id . ')">X</button> ') : '') . '
            </div>
            ';
            $i++;
        }
        ?>

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

    </div>

    <?php
    echo ($canUserEditGallery ? ('<div class="galleryUpload">
            <form action="" method="post" enctype="multipart/form-data">
                <h1>Upload file</h1>
                <label for="image">Description</label>
                <input id="imageDescriptionInput" type="text" name="fileDescription" placeholder="Image description...">
        
                <label for="image">Image</label>
                <input id="fileInput" type="file" name="file">
        
                <label for="resize">% compression*</label>
                <input id="resize" type="number" min="0" max="100" placeholder="Compression % (Optional)">
        
                <button onclick="uploadImage(' . $urlService->GetQueryParam('id')  . ')">Upload</button>        
            </form>    
        </div>') : "")
    ?>
    </div>

</body>

</html>