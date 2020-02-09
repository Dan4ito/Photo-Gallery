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
    include_once('../../Data Layer/repositories/ImageRepository.php');
    $cookieService = new CookieService();
    if (!$cookieService->isCookieValid()) {
        header('Location: ' . '.\\login.php');
    }
    $imageRepository = new ImageRepository();
    ?>
    <?php include '../components/navbar.php' ?>

    <div class="galleryContainer">
        <?php
        $images = $imageRepository->GetImages();

        foreach ($images as $image) {
            echo '
            <div style="display: inline-block;">
            <div style="height:200px; width:300px; background-size: contain; background-repeat: no-repeat; background-image: url(../../images/' . $image['name'] . ');"></div>
            <div class="imageInfo">
                <h3>' . $image['description'] . '</h3>
                <p>' . $image['timestamp'] . '</p>
            </div>
            </div>
            ';
        }
        ?>
    </div>

    <div class="galleryUpload">
        <form action="" method="post" enctype="multipart/form-data">
            <!-- <input type="text" name="fileTitle" placeholder="Image title..."> Tags ? -->
            <input id="imageDescriptionInput" type="text" name="fileDescription" placeholder="Image description...">
            <input id="fileInput" type="file" name="file">
            <button onclick="uploadImage()">Upload</button>
            <!-- <button type="submit" name="submit">Upload</button> -->
        </form>
    </div>
</body>

</html>