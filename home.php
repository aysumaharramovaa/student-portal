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
    session_start();
    if (!isset($_SESSION['ad'])) {
        header("Location: index.htm");
        exit();
    }

    include('database.php');

    $name = $_SESSION['ad'];
    $type = $_SESSION['type'];

    // ------------------ Əməliyyatlar ------------------
    
    // Müəllim əlavə/sil/redaktə
    if (isset($_POST['add_teacher'])) {
        $name_input = $_POST['name'];
        $surname_input = $_POST['surname'];
        $username_input = $_POST['username'];
        $conn->query("INSERT INTO users (name, surname, username, user_type) VALUES ('$name_input', '$surname_input', '$username_input', 'teacher')");
    }
    if (isset($_POST['delete_teacher'])) {
        $id = $_POST['id'];
        $conn->query("DELETE FROM users WHERE id=$id");
    }
    if (isset($_POST['edit_teacher'])) {
        $id = $_POST['id'];
        header("Location: edit.php?id=$id");
        exit();
    }

    // Tyutor əlavə/sil/redaktə
    if (isset($_POST['add_tutor'])) {
        $name_input = $_POST['name'];
        $surname_input = $_POST['surname'];
        $username_input = $_POST['username'];
        $conn->query("INSERT INTO users (name, surname, username, user_type) VALUES ('$name_input', '$surname_input', '$username_input', 'tutor')");
    }
    if (isset($_POST['delete_tutor'])) {
        $id = $_POST['id'];
        $conn->query("DELETE FROM users WHERE id=$id");
    }
    if (isset($_POST['edit_tutor'])) {
        $id = $_POST['id'];
        header("Location: edit.php?id=$id");
        exit();
    }

    // Tələbə əlavə/sil/redaktə
    if (isset($_POST['add_student'])) {
        $name_input = $_POST['name'];
        $surname_input = $_POST['surname'];
        $username_input = $_POST['username'];
        $conn->query("INSERT INTO users (name, surname, username, user_type) VALUES ('$name_input', '$surname_input', '$username_input', 'student')");
    }
    if (isset($_POST['delete_student'])) {
        $id = $_POST['id'];
        $conn->query("DELETE FROM users WHERE id=$id");
    }
    if (isset($_POST['edit_student'])) {
        $id = $_POST['id'];
        header("Location: edit.php?id=$id");
        exit();
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Student Portal</title>
        
    </head>

    <body>

        <h1>Welcome, <?php echo $name; ?>!</h1>
        <p>User Type: <?php echo $type; ?></p>

        <?php if ($type == "admin"): ?>

            <?php
            function renderUserSection($conn, $role, $label)
            {
                $result = $conn->query("SELECT id, CONCAT(name,' ',surname) AS fullname, username FROM users WHERE user_type='$role'");
                echo "<h2>$label</h2>";
                echo "<table>
        <tr><th>ID</th><th>Ad Soyad</th><th>Username</th><th>Əməliyyatlar</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
            <td>" . $row['id'] . "</td>
            <td>" . $row['fullname'] . "</td>
            <td>" . $row['username'] . "</td>
            <td>
                <form method='POST' class='inline'>
                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                    <button type='submit' name='edit_$role'>Redaktə et</button>
                </form>
                <form method='POST' class='inline'>
                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                    <button type='submit' name='delete_$role'>Sil</button>
                </form>
            </td>
        </tr>";
                }
                echo "</table>";
                echo "<form method='POST'>
        <input type='text' name='name' placeholder='Ad' required>
        <input type='text' name='surname' placeholder='Soyad' required>
        <input type='email' name='username' placeholder='Email' required>
        <button type='submit' name='add_$role'>+ Yeni $label əlavə et</button>
    </form>";
            }

            renderUserSection($conn, 'teacher', 'Müəllimlər');
            renderUserSection($conn, 'tutor', 'Tyutorlar');
            renderUserSection($conn, 'student', 'Tələbələr');

            $conn->close();
            ?>

        <?php endif; ?>

        <hr>
        <a href="logout.php">Logout</a>
    </body>

    </html>