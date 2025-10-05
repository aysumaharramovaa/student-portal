<?php
session_start();
if (!isset($_SESSION['ad']) || $_SESSION['type'] != "tutor") {
    header("Location: home.php");
    exit();
}

include('database.php');
$name = $_SESSION['ad'];
?>

<h1>Welcome, <?php echo $name; ?> (Tutor Dashboard)</h1>

<hr>
<h2>Teachers</h2>
<?php
$sql = "SELECT id, name, username FROM users WHERE type='teacher'";
$result = $conn->query($sql);

echo "<table border='1' cellpadding='10'>
        <tr><th>Name</th><th>Username</th><th>Actions</th></tr>";
while($row = $result->fetch_assoc()){
    echo "<tr>
            <td>".$row['name']."</td>
            <td>".$row['username']."</td>
            <td><a href='edit_user.php?id=".$row['id']."'>Edit</a></td>
          </tr>";
}
echo "</table>";
?>

<h3>Add New Teacher</h3>
<form action="add_teacher.php" method="POST">
    <input type="text" name="name" placeholder="Teacher Name" required>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Add Teacher</button>
</form>

<hr>
<h2>Groups</h2>
<?php
$sql = "SELECT g.id, g.group_name FROM groups g";
$result = $conn->query($sql);

echo "<table border='1' cellpadding='10'>
        <tr><th>Group Name</th><th>Actions</th></tr>";
while($row = $result->fetch_assoc()){
    echo "<tr>
            <td>".$row['group_name']."</td>
            <td><a href='edit_group.php?id=".$row['id']."'>Edit</a></td>
          </tr>";
}
echo "</table>";
?>

<h3>Add New Group</h3>
<form action="add_group.php" method="POST">
    <input type="text" name="group_name" placeholder="Group Name" required>
    <button type="submit">Add Group</button>
</form>

<hr>
<a href="logout.php">Logout</a>
