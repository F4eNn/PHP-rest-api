<?php

require __DIR__ . '/api/vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/api");
    $dotenv->load();

    $database = new Database($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USERNAME'], $_ENV['DB_PWD'], $_ENV['DB_PORT']);

    $conn = $database->getConnection();

    $sql = "INSERT INTO user (name, username, password_hash, api_key)
            VALUES (:name, :username, :password_hash, :api_key)";

    $stmt = $conn->prepare($sql);

    $api_key = bin2hex(random_bytes(16));
    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt->bindValue(":name", $_POST["name"], PDO::PARAM_STR);
    $stmt->bindValue(":username", $_POST["username"], PDO::PARAM_STR);
    $stmt->bindValue(":password_hash", $password_hash, PDO::PARAM_STR);
    $stmt->bindValue(":api_key", $api_key, PDO::PARAM_STR);

    $stmt->execute();

    echo "Thank You for registering. Your API key is ", $api_key;
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>

<body>
    <main class="container">
        <h1>Register</h1>

        <form method="post">
            <label for="name">Name</label>
            <input type="text" name="name" id="name">
            <label for="username">Username</label>
            <input type="text" name="username" id="username">
            <label for="password">Password</label>
            <input type="text" name="password" id="password">

            <button>Register</button>
        </form>
    </main>
</body>

</html>