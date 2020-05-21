<?php
include_once('../../Domain Layer/services/AuthorizationService.php');
include_once('../../Domain Layer/services/CookieService.php');
$authorizationService = new AuthorizationService();
$cookieService = new CookieService();
$isLoggedIn = $authorizationService->isLoggedIn();
?>


<div class="mainHeader">
    <?php if ($isLoggedIn) : ?>
        <div id="loginInfo">
            Logged in as
            <strong><?php echo $cookieService->getCookieValue("loginInfoToDisplay") ?></strong>
        </div>
    <?php endif; ?>
    <nav id="nav">
        <a class="navItem" href="index.php">Home</a>
        <?php if (!$isLoggedIn) : ?>
            <a class="navItem" href="login.php">Login</a>
        <?php endif; ?>
        <?php if (!$isLoggedIn) : ?>
            <a class="navItem" href="register.php">Sign up</a>
        <?php endif; ?>

        <?php if ($isLoggedIn) : ?>
            <a class="navItem" href="myGalleries.php">My Galleries</a>
            <a class="navItem" href="publicGalleries.php">Public Galleries</a>
            <a class="navItem" href="mergeGalleries.php">Merge Galleries</a>
            <a class="navItem" href="#" onclick="submitLogoutForm()">Logout</a>
        <?php endif; ?>
    </nav>
</div>