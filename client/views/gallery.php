<!DOCTYPE html>
<html lang="en">

<head>
    <title>PHP Gallery</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i&display=swap&subset=cyrillic,cyrillic-ext" rel="stylesheet">
    <link rel="stylesheet" href="../resources/css/style.css">
    <link rel="stylesheet" href="../resources/css/formsOutline.css">
    <link rel="stylesheet" href="../resources/css/displayGallery.css">
    <link rel="stylesheet" href="../resources/css/polaroidGallery.css">
    <link rel="stylesheet" href="../resources/css/filterGallery.css">

    <script type="text/javascript" src="../resources/js/script.js"></script>
    <script type="text/javascript" src="../resources/js/displayGallery.js"></script>
</head>

<body>
    <?php
    include_once('../../Domain Layer/services/CookieService.php');
    include_once('../../Domain Layer/services/UrlService.php');
    include_once('../../Domain Layer/services/GalleryUserValidatorService.php');
    include_once('../../Data Layer/repositories/ImageRepository.php');
    include_once('../../Data Layer/repositories/TagRepository.php');
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
    $tagRepository = new TagRepository();

    $canUserEditGallery = $galleryUserValidatorService->canUserEditGallery($galleryId);
    ?>
    <?php include '../components/navbar.php' ?>

    <div class="options">
        <input class="filter" id="filterDescription" type="text" placeholder="Filter images" name="filter">
        <select class="filter">
            <option value="" disabled selected>by</option>
            <option value="tag">tag</option>
            <option value="description">description</option>
            <option value="date">upload date</option>
        </select>
        <button class="filterButton">Filter</button>
        <button class="filterButton" id="selectMove">Move to</button>
        <button class="filterButton" id="selectMove">Select</button>
    </div>

    <?php
    if ($canUserEditGallery) {
        $tags = $tagRepository->GetAllTags();
        $str = "";
        foreach ($tags as $tag) {
            $str .= '<label>' . $tag->tag . '</label>';
            $str .= '<input type="checkbox" name=' . $tag->tag . ' value=' . $tag->tag . ' onclick="toggleCheckbox(' . $tag->tag . ')"/>';
        }
        echo
            '<div class="galleryUpload">
            <form class="formUpload" action="" method="post" enctype="multipart/form-data">
                <h1>Upload file</h1>
                <label for="image">Description</label>
                <input id="imageDescriptionInput" type="text" name="fileDescription" placeholder="Image description...">

                <label for="image">Image</label>
                <input id="fileInput" type="file" name="file" multiple="multiple">

                <label for="resize">Tags</label>' .
                $str
                .
                '<label for="resize">% file quality*</label>
                <input id="resize" type="number" min="0" max="100" placeholder="File quality % (Optional)">

                <button class="logButton" onclick="sendUploadImageRequest(' . $urlService->GetQueryParam('id') . ')">Upload</button>
            </form>
        </div>';
    }
    ?>


    <div class="galleryContainer">
        <?php
        $gallery = $galleryRepository->GetById($galleryId);
        $images = $imageRepository->GetImagesForGallery($galleryId);
        $i = 0;

        foreach ($images as $image) {
            echo '
            <div class="row">
            ' . ($canUserEditGallery ? ('<button class="deleteButton" onclick="deleteImageFromGallery(' . $image->id . ',' . $gallery->id . ')" onmouseover="highlightImage(' . $i . ')" onmouseout="normalizeImage(' . $i . ')">&times;</button>') : '') .
                '<img src="../../images/' . $image->name . '" id="imageToBeExpanded" class ="images" alt = ' . $image->timestamp . ' title = ' . $image->description . ' onclick="expandImage(this, ' . $i . ')" onmouseover="highlightImage(' . $i . ')" onmouseout="normalizeImage(' . $i . ')";>
                <div class="imageInfo">
                    <h3>' . $image->description . '</h3>
                    <p>' . $image->timestamp . '</p>
                </div>
            </div>
            ';
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

    <script>
        let selectedTags = [];
        toggleCheckbox = (tag) => {
            tag = tag.value;
            if (!selectedTags.includes(tag)) {
                selectedTags.push(tag);
            } else {
                selectedTags.splice(selectedTags.indexOf(tag), 1);
            }
        }

        sendUploadImageRequest = (galleryId) => {
            uploadImage(galleryId, selectedTags);
        }
    </script>
</body>

</html>