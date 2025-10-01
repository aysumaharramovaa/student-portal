<?php
session_start();
$ad = $_SESSION['ad'];
$type = $_SESSION['type'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal - Home</title>
    <link rel="stylesheet" href="home.css">

</head>

<body>
    <h1><?php echo htmlspecialchars($ad); ?></h1>
    <div class="container">
        <form action="add.php" method="post" enctype="multipart/form-data">
            <input type="file" name="sekil" id="fileToUpload">
            <label for="">Student Name:
                <input type="text" name='product' placeholder='Enter product name'>
            </label>
            <label for="">Student mail:
                <input type="text" name='mail' placeholder='Enter student mail'>
            </label>
            <label for="">Student specialty:
                <input type="text" name='specialty' placeholder='Enter student specialty'>
            </label>
            <input type="submit" value="Add">

        </form>


    </div>
    <div class="container">

        <table>
            <thead>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Mail</th>
                <th>Specialty</th>
                <th>Delete</th>
                <th>Edit</th>
            </thead>
            <tbody>
                <?php

                
                include('db.php'); // database connection
                



                $sql = "SELECT *FROM products ORDER BY id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if ($row['status'] == 1) {
                            echo "<tr>
      <td><img src='./uploads/" . $row['sekil'] . "'/></td>
            <td>" . $row['id'] . "</td>
            <td>" . $row['product'] . "</td>
            <td>" . $row['mail'] . "</td>
            <td>" . $row['specialty'] . "</td>";
                            if ($type == 'admin') {
                                echo "<td><a href='delete.php?id=" . $row['id'] . "'>Delete</a></td>
                <td><a href='edit.php?id=" . $row['id'] . "'>Edit</a></td>
                ";
                            } else {
                                echo "<td><a href='#'>No Delete</a></td>
                 <td><a href='#'>No Edit</a></td>";
                            }

                            echo "  </tr> ";
                        }
                    }
                } else {
                    echo "0 results";
                }
                $conn->close();
                ?>

            </tbody>
        </table>


        <a href="trash.php">Delete Students</a>
    </div>



</body>

</html>