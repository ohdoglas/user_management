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

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
        method="post">
        <h2>Register Form</h2> <br>
        <h4>Account Information</h4><br>
        Username: <br>
        <input type="text" name="username"
            pattern="[A-Za-z0-9]+" required> <br>
        E-mail: <br>
        <input type="email" name="email" required> <br>
        Password: <br>
        <input type="password" name="password" required> <br>
        Repeat Password <br>
        <input type="password" name="passwordR" required> <br>


        <h4>Personal Information</h4><br>
        First Name: <br>
        <input type="text" name="fname"> <br>
        Last Name: <br>
        <input type="text" name="lname"> <br>
        <br>
        Select your gender: <br>
        Male <input type="radio" name="gender" value="male" required>
        Female <input type="radio" name="gender" value="fem" required> <br>
        <br>
        CPF: <br>
        <input type="text" name="cpf" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}"
            placeholder="xxx.xxx.xxx-xx" required><br>
        Phone: <br>
        <input type="text" name="phone"
            pattern="\(\d{2}\)\s\d{4,5}-\d{4}" placeholder="(xx) xxxxx-xxxx" required> <br>

        Birth Date: <br>
        <input type="date" name="birth"
            min="1900-01-01" max="2024-01-01" required>
        <h4>Address Information</h4> <br>
        Address: <br>
        <input type="text" name="address"
            autocomplete="address-line1" required><br>
        City: <br>
        <input type="text" name="city"> <br>
        State/Province: <br>
        <input type="text" name="state"> <br>
        ZIP/Postal Code: <br>
        <input type="text" name="postal_code" pattern="\d{5}-\d{3}"
            placeholder="xxxxx-xxx" required> <br>
        Country: <br>
        <input type="text" name="country"> <br>

        <br>
        <input type="submit" name="Sign Up" value="register">

    </form>
</body>

</html>

<?php
include("../src/public/footer.html")
?>