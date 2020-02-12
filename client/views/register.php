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

<body>
    <?php include '../components/navbar.php' ?>
    <form onsubmit="submitCreateForm()">
        <h1>Register new user</h1>
        <label for="username">Username</label>
        <input id="username" type="text" placeholder="Username"></input>
        <label for="email">Email</label>
        <input id="email" type="email" placeholder="Email"></input>
        <label for="password">Password</label>
        <input id="password" type="password" placeholder="Password"></input>
        <input class="logButton" type="submit" value="Register"></input>
    </form>
</body>

</html>