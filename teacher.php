<?php
session_start();
if (!isset($_SESSION['ad']) || $_SESSION['type'] != "teacher") {
    header("Location: home.php");
    exit();
}

include('database.php');
$name = $_SESSION['ad'];
?>

<h1>Welcome, <?php echo $name; ?> (Teacher Dashboard)</h1>

<h2>Your Groups</h2>
<?php
// Müəllimin qruplarını seç
$sql = "SELECT g.id as group_id, g.group_name
        FROM groups g
        JOIN users t ON g.tutor_id = t.id
        WHERE t.username='$name'";
$result = $conn->query($sql);

if($result->num_rows > 0){
    echo "<ul>";
    while($row = $result->fetch_assoc()){
        $group_id = $row['group_id'];
        echo "<li>
                <a href='#' class='group' data-id='$group_id'>".$row['group_name']."</a>
                <div class='group-details' id='group-$group_id' style='display:none; margin-left:20px;'>
                    <ul>";

       
        $sql2 = "SELECT u.name as student_name, s.subject_name
                 FROM student_groups sg
                 JOIN users u ON sg.student_id = u.id
                 JOIN subjects s ON s.teacher_id = (SELECT id FROM users WHERE username='$name')
                 WHERE sg.group_id='$group_id'";
        $res2 = $conn->query($sql2);
        while($row2 = $res2->fetch_assoc()){
            echo "<li>".$row2['student_name']." - ".$row2['subject_name']."</li>";
        }

        echo "</ul></div></li>";
    }
    echo "</ul>";
} else {
    echo "<p>No groups assigned yet.</p>";
}
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('.group').click(function(e){
        e.preventDefault();
        var id = $(this).data('id');
        $('#group-' + id).toggle();
    });
});
</script>

<hr>
<a href="logout.php">Logout</a>
