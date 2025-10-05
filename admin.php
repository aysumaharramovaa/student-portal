<?php
session_start();
if (!isset($_SESSION['ad']) || $_SESSION['type'] != "admin") {
    header("Location: home.php");
    exit();
}

include('database.php');
$name = $_SESSION['ad'];
?>

<h1>Welcome, <?php echo $name; ?> (Admin Dashboard)</h1>

<hr>
<h2>Teachers</h2>
<?php
$res = $conn->query("SELECT id, name, username FROM users WHERE type='teacher'");
echo "<table border='1' cellpadding='10'>
      <tr><th>Name</th><th>Username</th><th>Actions</th></tr>";
while($row = $res->fetch_assoc()){
    echo "<tr>
            <td>".$row['name']."</td>
            <td>".$row['username']."</td>
            <td>
                <a href='edit_user.php?id=".$row['id']."'>Edit</a> |
                <a href='delete_user.php?id=".$row['id']."'>Delete</a>
            </td>
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
$res = $conn->query("SELECT g.id, g.group_name, t.name as tutor_name FROM groups g LEFT JOIN users t ON g.tutor_id=t.id");
echo "<table border='1' cellpadding='10'>
      <tr><th>Group Name</th><th>Tutor</th><th>Actions</th></tr>";
while($row = $res->fetch_assoc()){
    echo "<tr>
            <td>".$row['group_name']."</td>
            <td>".$row['tutor_name']."</td>
            <td>
                <a href='edit_group.php?id=".$row['id']."'>Edit</a> |
                <a href='delete_group.php?id=".$row['id']."'>Delete</a>
            </td>
          </tr>";
}
echo "</table>";
?>

<h3>Add New Group</h3>
<form action="add_group.php" method="POST">
    <input type="text" name="group_name" placeholder="Group Name" required>
    <select name="tutor_id" required>
        <option value="">Select Tutor</option>
        <?php
        $tutors = $conn->query("SELECT id, name FROM users WHERE type='tutor'");
        while($t = $tutors->fetch_assoc()){
            echo "<option value='".$t['id']."'>".$t['name']."</option>";
        }
        ?>
    </select>
    <button type="submit">Add Group</button>
</form>

<hr>
<a href="logout.php">Logout</a>
