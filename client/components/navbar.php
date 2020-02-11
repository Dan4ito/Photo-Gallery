<?php
include_once('../../Domain Layer/services/AuthorizationService.php');
include_once('../../Domain Layer/services/CookieService.php');
$authorizationService = new AuthorizationService();
$cookieService = new CookieService();
$isLoggedIn = $authorizationService->isLoggedIn();
?>


<div class="mainHeader">
    <a class="navBar" href="index.php">Home</a>
    <?php if (!$isLoggedIn) : ?>
        <a class="navBar" href="login.php">Login</a>
    <?php endif; ?>
    <?php if (!$isLoggedIn) : ?>
        <a class="navBar" href="register.php">Register a user</a>
    <?php endif; ?>

    <?php if ($isLoggedIn) : ?>
        <a class="navBar" href="myGalleries.php">My Galleries</a>
        <a class="navBar" href="publicGalleries.php">Public Galleries</a>
        <a class="navBar" href="#" onclick="submitLogoutForm()">Logout</a>
        <div id="loginInfo">
            Logged in as
            <?php echo $cookieService->getCookieValue("loginInfoToDisplay") ?>
        </div>
    <?php endif; ?>
</div>