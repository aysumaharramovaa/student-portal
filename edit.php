<?php
include("database.php");
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM users WHERE id=$id");
$row = $result->fetch_assoc();

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $conn->query("UPDATE users SET name='$name', username='$username' WHERE id=$id");
    header("Location: admin.php");
    exit();
}
?>
<form method="POST">
    <input type="text" name="name" value="<?php echo $row['name']; ?>">
    <input type="email" name="username" value="<?php echo $row['username']; ?>">
    <button type="submit" name="update">edit</button>
</form>
