<?php
include("../src/config/database.php");
include("../src/public/header.html");

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $passwordR = filter_input(INPUT_POST, "passwordR", FILTER_SANITIZE_SPECIAL_CHARS);
    $f_name = filter_input(INPUT_POST, "fname", FILTER_SANITIZE_SPECIAL_CHARS);
    $l_name = filter_input(INPUT_POST, "lname", FILTER_SANITIZE_SPECIAL_CHARS);
    $gender = filter_input(INPUT_POST, "gender", FILTER_SANITIZE_SPECIAL_CHARS);
    $cpf = filter_input(INPUT_POST, "cpf", FILTER_SANITIZE_SPECIAL_CHARS);
    $phone = filter_input(INPUT_POST, "phone", FILTER_SANITIZE_SPECIAL_CHARS);
    $birth = filter_input(INPUT_POST, "birth", FILTER_SANITIZE_SPECIAL_CHARS);
    $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_SPECIAL_CHARS);
    $city = filter_input(INPUT_POST, "city", FILTER_SANITIZE_SPECIAL_CHARS);
    $state = filter_input(INPUT_POST, "state", FILTER_SANITIZE_SPECIAL_CHARS);
    $zip = filter_input(INPUT_POST, "postal_code", FILTER_SANITIZE_SPECIAL_CHARS);
    $country = filter_input(INPUT_POST, "country", FILTER_SANITIZE_SPECIAL_CHARS);

    // Validação dos campos
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid e-mail";
    } elseif ($password !== $passwordR) {
        $error_message = "Password does not match";
    } elseif (empty($username) || empty($email) || empty($password) || empty($f_name) || empty($l_name) || empty($gender) || empty($cpf) || empty($phone) || empty($birth) || empty($address) || empty($city) || empty($state) || empty($zip) || empty($country)) {
        $error_message = "Enter all required fields";
    }

    // Verificar se o nome de usuário já existe
    if (empty($error_message)) {
        $stmt_check_user = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt_check_user->bind_param("s", $username);
        $stmt_check_user->execute();
        $stmt_check_user->bind_result($user_count);
        $stmt_check_user->fetch();
        $stmt_check_user->close();

        if ($user_count > 0) {
            $error_message = "Username is already taken. Please choose another one.";
        }
    }

    // Verificar se o e-mail já existe
    if (empty($error_message)) {
        $stmt_check_email = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt_check_email->bind_param("s", $email);
        $stmt_check_email->execute();
        $stmt_check_email->bind_result($email_count);
        $stmt_check_email->fetch();
        $stmt_check_email->close();

        if ($email_count > 0) {
            $error_message = "Email is already registered. Please use another one.";
        }
    }

    // Verificar se o cpf já existe
    if (empty($error_message)) {
        $stmt_check_cpf = $conn->prepare("SELECT COUNT(*) FROM personal_info WHERE cpf = ?");
        $stmt_check_cpf->bind_param("s", $cpf);
        $stmt_check_cpf->execute();
        $stmt_check_cpf->bind_result($cpf_count);
        $stmt_check_cpf->fetch();
        $stmt_check_cpf->close();

        if ($cpf_count > 0) {
            $error_message = "CPF is already registered. Please use another one.";
        }
    }

    if (empty($error_message)) {
        $hash = password_hash($password, PASSWORD_BCRYPT);

        // Inserindo o novo usuário
        $stmt_user = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        $stmt_user->bind_param("sss", $username, $hash, $email);

        // Executar a inserção
        if ($stmt_user->execute()) {
            // Obter o id gerado
            $user_id = $conn->insert_id;

            // Inserindo informações pessoais
            $stmt_p_info = $conn->prepare("INSERT INTO personal_info (user_id, first_name, last_name, gender, cpf, phone, birth_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt_p_info->bind_param("issssss", $user_id, $f_name, $l_name, $gender, $cpf, $phone, $birth);

            // Inserindo informações de endereço
            $stmt_address = $conn->prepare("INSERT INTO address_info (user_id, address, city, state, postal_code, country) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt_address->bind_param("isssss", $user_id, $address, $city, $state, $zip, $country);

            // Executando as inserções
            if ($stmt_p_info->execute() && $stmt_address->execute()) {
                echo "You are now registered";
            } else {
                echo "Error: " . $stmt_p_info->error;
            }
        } else {
            echo "Error: " . $stmt_user->error;
        }
    } else {
        echo $error_message; // Exibir a mensagem de erro se houver
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>
    <a href="./index.php">Homepage</a>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h2>Register Form</h2>
        <h4>Account Information</h4>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" pattern="[A-Za-z0-9]+" required><br>
        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>
        <label for="passwordR">Repeat Password:</label>
        <input type="password" name="passwordR" id="passwordR" required><br>

        <h4>Personal Information</h4>
        <label for="fname">First Name:</label>
        <input type="text" name="fname" id="fname" required><br>
        <label for="lname">Last Name:</label>
        <input type="text" name="lname" id="lname" required><br>
        <label>Select your gender:</label><br>
        <label for="male">Male</label>
        <input type="radio" name="gender" value="male" id="male" required>
        <label for="female">Female</label>
        <input type="radio" name="gender" value="fem" id="female" required><br>
        <label for="cpf">CPF:</label>
        <input type="text" name="cpf" id="cpf" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" placeholder="xxx.xxx.xxx-xx" required><br>
        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" pattern="\(\d{2}\)\s\d{4,5}-\d{4}" placeholder="(xx) xxxxx-xxxx" required><br>
        <label for="birth">Birth Date:</label>
        <input type="date" name="birth" id="birth" min="1900-01-01" max="2024-01-01" required><br>

        <h4>Address Information</h4>
        <label for="address">Address:</label>
        <input type="text" name="address" id="address" required><br>
        <label for="city">City:</label>
        <input type="text" name="city" id="city" required><br>
        <label for="state">State/Province:</label>
        <input type="text" name="state" id="state" required><br>
        <label for="postal_code">ZIP/Postal Code:</label>
        <input type="text" name="postal_code" id="postal_code" pattern="\d{5}-\d{3}" placeholder="xxxxx-xxx" required><br>
        <label for="country">Country:</label>
        <input type="text" name="country" id="country" required><br>

        <input type="submit" value="Register">
    </form>

    <?php
    if (!empty($error_message)) {
        echo "<div class='error'>" . htmlspecialchars($error_message) . "</div>";
    }
    ?>
</body>

</html>

<?php
include("../src/public/footer.html");
?>