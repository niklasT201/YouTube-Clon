<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <title>Delete Video</title>
</head>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        font-size: 20px;
        background: radial-gradient(circle, #000000, #202020);
        color: white;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .submit {
        margin-top: 20px;
        background-color: transparent;
        border: 1px solid white;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        margin-top: 20%;
        margin-bottom: 20px;
    }

    .submit:hover {
        background-color: white;
        color: black;
    }

</style>
<body>
    <form action="index.php">
    <button class="submit">Go Back</button>
    </form>
<?php
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['name'])) {
        // Redirect the user to the login page if not logged in
        header("Location: login.php");
        exit;
    }

    // Check if video ID is provided in the URL
    if(isset($_GET['id'])) {
        $video_id = $_GET['id'];

        // Connect to the database
        $mysqli = new mysqli("localhost", "root", "", "niklas_stadie");

        // Check connection
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }

        // Prepare SQL statement to delete the video
        $sql = "DELETE FROM videos WHERE id=? AND creator=?";

        // Prepare and bind parameters
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("is", $video_id, $_SESSION['name']);

        // Execute the statement
        if ($stmt->execute()) {
            // Video deleted successfully
            echo "Video deleted successfully.";
        } else {
            echo "Error deleting video: " . $mysqli->error;
        }

        // Close statement and database connection
        $stmt->close();
        $mysqli->close();
    }
?>

</body>
</html>

