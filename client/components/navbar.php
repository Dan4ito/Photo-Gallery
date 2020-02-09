<?php
include_once('../../Domain Layer/services/AuthorizationService.php');
include_once('../../Domain Layer/services/CookieService.php');
$authorizationService = new AuthorizationService();
$cookieService = new CookieService();
$isLoggedIn = $authorizationService->isLoggedIn();
?>





<a href="index.php">Home</a>
<?php if (!$isLoggedIn) : ?>
    <a href="login.php">Login</a>
<?php endif; ?>
<?php if (!$isLoggedIn) : ?>
    <a href="register.php">Register a user</a>
<?php endif; ?>

<?php if ($isLoggedIn) : ?>
    <a href="gallery.php">Upload&Display</a>
    <a href="myGalleries.php">My Galleries</a>
    <a href="#" onclick="submitLogoutForm()">Logout</a>
    <div id="loginInfo">
        Logged in as
        <?php echo $cookieService->getCookieValue("loginInfoToDisplay") ?>
    </div>
<?php endif; ?>