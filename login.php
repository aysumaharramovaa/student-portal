<?php
include('database.php');
session_start();

$user = $_POST["user"];
$pass = $_POST['pass'];

$sql = "SELECT *FROM users WHERE username='$user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
 while($row = $result->fetch_assoc()) {
  $sifrelenmis = $row['password'];
$name = $row['name'];
$usert_type = $row['user_type'];

  if(password_verify($pass,$sifrelenmis)){
    $_SESSION['ad'] = $name;
    $_SESSION['type'] = $usert_type;
    header("location:home.php");
    exit();
  }   

  }
} else {
  echo "Username or Password invalid!";
}
$conn->close();
?>