<?php
include('database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $user = $_POST["user"];
    $pass = $_POST['pass'];
    $sifrelenmis = password_hash($pass, PASSWORD_DEFAULT);
    $user_type = $_POST['user_type'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, name, surname, user_type) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $user, $sifrelenmis, $name, $surname, $user_type);

    if ($stmt->execute()) {
        header('Location: index.htm');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
