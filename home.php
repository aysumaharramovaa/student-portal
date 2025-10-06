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
    <title>Student Portal</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

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
        echo "<h1>Welcome, $name!</h1>
        <p>User Type: $type</p>";
        echo "<h2>Your Classes</h2>";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p>Group: " . $row['group_name'] . " | Teacher: " . $row['teacher_name'] . " | Subject: " . $row['subject_name'] . "</p>";
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



        //admin
    } elseif ($type == "admin") {


        echo "<style>
            .section {
                margin: 20px auto;
                padding: 15px;
                border: 1px solid #ccc;
                border-radius: 8px;
                width: 80%;
                background: #000000ff;
            }
            .section h3 {
                margin-top: 0;
                text-align:center;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 10px;
            }
            th, td {
                border: 1px solid ;
                padding: 8px;
                text-align: center;
            }
            th {
                background: #898585ff;
            }
            button {
                padding: 5px 10px;
                margin: 2px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }
            .edit-btn { background: #4CAF50; color: white; }
            .delete-btn { background: #f44336; color: white; }
            .add-btn { background: #2196F3; color: white; width: 100%; padding: 8px; }
        </style>";

        // muellim hissesi
        echo "<div class='section'>
            <h3>Müəllimlər</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Ad Soyad</th>
                    <th>Username</th>
                    <th>Əməliyyatlar</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Müəllim 1</td>
                    <td>muellim1@example.com</td>
                    <td>
                        <button class='edit-btn'>Redaktə et</button>
                        <button class='delete-btn'>Sil</button>
                    </td>
                </tr>
            </table>
            <button class='add-btn'>+ Yeni müəllim əlavə et</button>
          </div>
          ";
        echo "\n";
        echo "<br/>";

        // tyutor hissesi
        echo "<div class='section'>
            <h3>Tyutorlar</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Ad Soyad</th>
                    <th>Username</th>
                    <th>Əməliyyatlar</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Tyutor 1</td>
                    <td>tyutor1@example.com</td>
                    <td>
                        <button class='edit-btn'>Redaktə et</button>
                        <button class='delete-btn'>Sil</button>
                    </td>
                </tr>
            </table>
            <button class='add-btn'>+ Yeni tyutor əlavə et</button>
          </div>";

        // student
        echo "<div class='section'>
            <h3>Tələbələr</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Ad Soyad</th>
                    <th>Username</th>
                    <th>Əməliyyatlar</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Tələbə 1</td>
                    <td>telebe1@example.com</td>
                    <td>
                        <button class='edit-btn'>Redaktə et</button>
                        <button class='delete-btn'>Sil</button>
                    </td>
                </tr>
            </table>
            <button class='add-btn'>+ Yeni tələbə əlavə et</button>
          </div>";
    }



    $conn->close();
    ?>

    <hr>
    <br />
    <a href="logout.php">Logout</a>
</body>

</html>