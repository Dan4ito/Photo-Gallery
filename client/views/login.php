<!DOCTYPE html>
<html lang="en">

<head>
    <title>PHP Gallery</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../resources/css/style.css">
    <link rel="stylesheet" href="../resources/css/formsOutline.css">
    <script type="text/javascript" src="../resources/js/script.js"></script>
</head>
<?php
include_once('../../Domain Layer/services/AuthorizationService.php');
$authorizationService = new AuthorizationService();
if ($authorizationService->isLoggedIn()) {
    header('Location: ' . '.\\index.php');
}
?>

<body>
    <?php include '../components/navbar.php' ?>
    <form onsubmit="submitLoginForm()">
        <h1>Login</h1>
        <label for="email">Email</label>
        <input id="email" type="email" placeholder="Email"></input>
        <label for="password">Password</label>
        <input id="password" type="password" placeholder="Password"></input>
        <input class="logButton" type="submit" value="Login"></input>
    </form>

</body>

</html>