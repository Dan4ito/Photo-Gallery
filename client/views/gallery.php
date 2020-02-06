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
    $cookieService = new CookieService();
    if (!$cookieService->isCookieValid()) {
        header('Location: ' . '.\\login.php');
    }
    ?>
    <?php include '../components/navbar.php' ?>
    <span id="endLoginInfo"></span>
    <form onsubmit="submitFindAllForm()">
        <div id="errorsInfo"></div>
        <div id="successInfo"></div>
        <h1>View Gallery</h1>
    </form>
    <div id="responseInfo"></div>
</body>

</html>