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

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h2>Register Form</h2>
        Username: <br>
        <input type="text" name="username"> <br>
        E-mail: <br>
        <input type="text" name="email"> <br>
        Password: <br>
        <input type="password" name="password"> <br>
        Repeat Password <br>
        <input type="password" name="passwordR"> <br>
        Select your gender: <br>
        Male <input type="radio" name="gender" value="male">
        Female <input type="radio" name="gender" value="fem"> <br>
    </form>
</body>

</html>

<?php
include("../src/public/footer.html")
?>