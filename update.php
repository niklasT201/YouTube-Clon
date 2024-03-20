<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <title>YouTube</title>
</head>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background: radial-gradient(circle, #000000, #202020);
        color: white;
    }

    form {
        justify-content: center;
        align-items: center;
        text-align: center;
        margin-top: 50px;
        font-size: 18px;
    }

    form textarea {
        width: 550px;
    }

    .submit {
        margin-top: 20px;
        background-color: transparent;
        border: 1px solid white;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        text-decoration: none;
    }

    .submit:hover {
        background-color: white;
        color: black;
    }
</style>

<body>
    <form action="update.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label><br>
        <textarea id="title" name="title" style="width: 550px; height: 40px"></textarea><br><br>
        
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" style="height: 200px";></textarea><br><br>

        <button type="submit" class="submit">Submit</button>
        <a href="index.php" class="submit">HOME</a>
    </form>

    <?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['id'])) {
        // Check if the user is logged in
        if (!isset($_SESSION['name'])) {
            // Redirect the user to the login page or display an error message
            header("Location: login.php");
            exit;
        }

        // Validate and sanitize form input
        $title = trim($_POST["title"]);
        $description = trim($_POST["description"]);
        $id = $_GET['id'];

        // Update the video record in the database
        $mysqli = new mysqli("localhost", "root", "", "niklas_stadie");

        // Check connection
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        // Prepare SQL statement to update video details
        $stmt = $mysqli->prepare("UPDATE videos SET title = ?, description = ? WHERE id = ?");
        $stmt->bind_param("ssi", $title, $description, $id);

        // Execute the update query
        if ($stmt->execute()) {
            echo "Video details updated successfully.";
        } else {
            echo "Error updating video details: " . $mysqli->error;
        }

        // Close the database connection and statement
        $stmt->close();
        $mysqli->close();
    }
    ?>
</body>
</html>
