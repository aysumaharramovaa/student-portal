<?php
session_start();
if (!isset($_SESSION['ad']) || $_SESSION['type'] != "student") {
    header("Location: home.php");
    exit();
}

include('database.php');
$name = $_SESSION['ad'];
?>

<h1>Welcome, <?php echo $name; ?>!</h1>
<h2>Your Classes</h2>

<?php
$sql = "SELECT g.group_name, t.name as teacher_name, s.subject_name
        FROM student_groups sg
        JOIN groups g ON sg.group_id = g.id
        JOIN users t ON g.tutor_id = t.id
        JOIN subjects s ON s.teacher_id = t.id
        JOIN users u ON sg.student_id = u.id
        WHERE u.username = '$name'";
$result = $conn->query($sql);

if($result->num_rows > 0){
    echo "<table border='1' cellpadding='10'><tr><th>Group</th><th>Teacher</th><th>Subject</th></tr>";
    while($row = $result->fetch_assoc()){
        echo "<tr>
                <td>".$row['group_name']."</td>
                <td>".$row['teacher_name']."</td>
                <td>".$row['subject_name']."</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No classes assigned yet.</p>";
}
?>

<a href="logout.php">Logout</a>
