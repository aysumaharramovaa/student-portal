<?php
session_start();
if (!isset($_SESSION['ad'])) {
    header("Location: index.htm");
    exit();
}

include('database.php');

$name = $_SESSION['ad'];
$type = $_SESSION['type'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Home-Student Portal</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Welcome, <?php echo $name; ?>!</h1>
<p>User Type: <?php echo $type; ?></p>
<hr>

<?php
if ($type == "student") {
    $sql = "SELECT g.group_name, t.name as teacher_name, s.subject_name
            FROM student_groups sg
            JOIN groups g ON sg.group_id = g.id
            JOIN users t ON g.tutor_id = t.id
            JOIN subjects s ON s.teacher_id = t.id
            JOIN users u ON sg.student_id = u.id
            WHERE u.username = '$name'";
    $result = $conn->query($sql);

    echo "<h2>Your Classes</h2>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p>Group: ".$row['group_name']." | Teacher: ".$row['teacher_name']." | Subject: ".$row['subject_name']."</p>";
        }
    } else {
        echo "<p>No classes assigned yet.</p>";
    }

} elseif ($type == "tutor") {
    echo "<h2>Tutor Dashboard</h2>";
    echo "<p>You can create and edit students and groups (cannot delete)</p>";  


} elseif ($type == "teacher") {
    echo "<h2>Teacher Dashboard</h2>";
    echo "<p>You can see only your groups and subjects</p>";
  

} elseif ($type == "admin") {
    echo "<h2>Admin Dashboard</h2>";
    echo "<p>You can add/edit/delete users, teachers, tutors, and students</p>";

}

$conn->close();
?>

<hr>
<a href="logout.php">Logout</a>
</body>
</html>
