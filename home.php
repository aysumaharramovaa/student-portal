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
    
    // Müəllim əlavə
    if (isset($_POST['add_teacher'])) {
        $name_input = $_POST['name'];
        $surname_input = $_POST['surname'];
        $username_input = $_POST['username'];
        $conn->query("INSERT INTO users (name, surname, username, user_type) VALUES ('$name_input', '$surname_input', '$username_input', 'teacher')");
    }

    // Müəllim sil
    if (isset($_POST['delete_teacher'])) {
        $id = $_POST['id'];
        $conn->query("DELETE FROM users WHERE id=$id");
    }

    // Müəllim redaktə
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
        <link rel="stylesheet" href="style.css">
    </head>

    <body>

        <hr>

        <?php if ($type == "admin"): ?>

            <style>
                /* Ümumi bölmələr */
.section {
    margin: 30px auto;
    padding: 20px;
    width: 90%;
    max-width: 900px;
    background-color: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    font-family: Arial, sans-serif;
}

/* Başlıqlar */
.section h3 {
    margin-bottom: 15px;
    color: #333;
    font-size: 1.5em;
    border-bottom: 2px solid #007BFF;
    padding-bottom: 5px;
}

/* Cədvəl tərzi */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 15px;
}

table th, table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

table th {
    background-color: #007BFF;
    color: #fff;
}

table tr:nth-child(even) {
    background-color: #f2f2f2;
}

/* Düymələr */
button {
    cursor: pointer;
    padding: 6px 12px;
    border: none;
    border-radius: 5px;
    font-size: 0.9em;
    transition: 0.3s;
}

.edit-btn {
    background-color: #ffc107;
    color: #fff;
}

.edit-btn:hover {
    background-color: #e0a800;
}

.delete-btn {
    background-color: #dc3545;
    color: #fff;
}

.delete-btn:hover {
    background-color: #c82333;
}

.add-btn {
    background-color: #28a745;
    color: #fff;
    margin-top: 10px;
}

.add-btn:hover {
    background-color: #218838;
}

/* Form elementləri */
form input[type="text"],
form input[type="email"] {
    padding: 8px;
    margin-right: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: calc(33% - 14px);
}

form input[type="text"]:focus,
form input[type="email"]:focus {
    border-color: #007BFF;
    outline: none;
}
            </style>

            <?php
            // --- Müəllimlər ---
            $result = $conn->query("SELECT id, CONCAT(name,' ',surname) AS fullname, username FROM users WHERE user_type='teacher'");
            echo "<div class='section'>
<h3>Müəllimlər</h3>
<table>
<tr><th>ID</th><th>Ad Soyad</th><th>Username</th><th>Əməliyyatlar</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
    <td>" . $row['id'] . "</td>
    <td>" . $row['fullname'] . "</td>
    <td>" . $row['username'] . "</td>
    <td>
        <form method='POST' style='display:inline;'>
            <input type='hidden' name='id' value='" . $row['id'] . "'>
            <button type='submit' name='edit_teacher' class='edit-btn'>Redaktə et</button>
        </form>
        <form method='POST' style='display:inline;'>
            <input type='hidden' name='id' value='" . $row['id'] . "'>
            <button type='submit' name='delete_teacher' class='delete-btn'>Sil</button>
        </form>
    </td>
    </tr>";
            }
            echo "</table>
<form method='POST'>
<input type='text' name='name' placeholder='Ad' required>
<input type='text' name='surname' placeholder='Soyad' required>
<input type='email' name='username' placeholder='Email' required>
<button type='submit' name='add_teacher' class='add-btn'>+ Yeni müəllim əlavə et</button>
</form>
</div>";

            // --- Tyutorlar ---
            $result = $conn->query("SELECT id, CONCAT(name,' ',surname) AS fullname, username FROM users WHERE user_type='tutor'");
            echo "<div class='section'>
<h3>Tyutorlar</h3>
<table>
<tr><th>ID</th><th>Ad Soyad</th><th>Username</th><th>Əməliyyatlar</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
    <td>" . $row['id'] . "</td>
    <td>" . $row['fullname'] . "</td>
    <td>" . $row['username'] . "</td>
    <td>
        <form method='POST' style='display:inline;'>
            <input type='hidden' name='id' value='" . $row['id'] . "'>
            <button type='submit' name='edit_tutor' class='edit-btn'>Redaktə et</button>
        </form>
        <form method='POST' style='display:inline;'>
            <input type='hidden' name='id' value='" . $row['id'] . "'>
            <button type='submit' name='delete_tutor' class='delete-btn'>Sil</button>
        </form>
    </td>
    </tr>";
            }
            echo "</table>
<form method='POST'>
<input type='text' name='name' placeholder='Ad' required>
<input type='text' name='surname' placeholder='Soyad' required>
<input type='email' name='username' placeholder='Email' required>
<button type='submit' name='add_tutor' class='add-btn'>+ Yeni tyutor əlavə et</button>
</form>
</div>";

            // --- Tələbələr ---
            $result = $conn->query("SELECT id, CONCAT(name,' ',surname) AS fullname, username FROM users WHERE user_type='student'");
            echo "<div class='section'>
<h3>Tələbələr</h3>
<table>
<tr><th>ID</th><th>Ad Soyad</th><th>Username</th><th>Əməliyyatlar</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
    <td>" . $row['id'] . "</td>
    <td>" . $row['fullname'] . "</td>
    <td>" . $row['username'] . "</td>
    <td>
        <form method='POST' style='display:inline;'>
            <input type='hidden' name='id' value='" . $row['id'] . "'>
            <button type='submit' name='edit_student' class='edit-btn'>Redaktə et</button>
        </form>
        <form method='POST' style='display:inline;'>
            <input type='hidden' name='id' value='" . $row['id'] . "'>
            <button type='submit' name='delete_student' class='delete-btn'>Sil</button>
        </form>
    </td>
    </tr>";
            }
            echo "</table>
<form method='POST'>
<input type='text' name='name' placeholder='Ad' required>
<input type='text' name='surname' placeholder='Soyad' required>
<input type='email' name='username' placeholder='Email' required>
<button type='submit' name='add_student' class='add-btn'>+ Yeni tələbə əlavə et</button>
</form>
</div>";

            $conn->close();
        endif;
        ?>

        <hr>
        <br />
        <a href="logout.php">Logout</a>
    </body>

    </html>