<?php
include("../src/public/header.html")
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <a href="./index.php">Homepage</a>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <h2>Login</h2>
        <h4>Please enter your credentials for Login</h4>
        Username or E-mail: <br>
        <input type="text" name="usernameOrEmail"> <br>
        Password: <br>
        <input type="password" name="password"> <br>
        <input type="submit" name="login" value="login">
    </form>
</body>

</html>


<?php
include("../src/public/footer.html")
?>