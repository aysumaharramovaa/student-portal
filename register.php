<?php
include('db.php');

$name = $_POST['name'];
$surname = $_POST['surname'];
$user = $_POST["user"];
$pass = $_POST['pass'];
$sifrelenmis = password_hash($pass,PASSWORD_DEFAULT);
$user_type = $_POST['user_type'];


$sql = "INSERT INTO users (username, password, name,surname,user_type) VALUES ('$user', '$sifrelenmis', '$name','$surname','$user_type')";

if ($conn->query($sql) === TRUE) {
 header('location:index.htm');
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>