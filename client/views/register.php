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
    <?php include '../components/navbar.php' ?>
    <form onsubmit="submitCreateForm()">
        <h1>Register new user</h1>
        <label for="username">Username</label>
        <input id="username" type="text" placeholder="Username"></input>
        <label for="email">Email</label>
        <input id="email" type="email" placeholder="Email"></input>
        <label for="password">Password</label>
        <input id="password" type="password" placeholder="Password"></input>
        <input type="submit" value="Register"></input>
    </form>
</body>

</html>