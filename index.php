<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <title>YouTube Clon</title>
</head>
<body>
    <header>
        <nav>
            <a href="#">Home</a>
            <input type="text">
            <button class="submit"></button>
            <?php
            // Check if the user is logged in (i.e., if the session variable is set)
            session_start();
            if(isset($_SESSION['name'])) {
                echo '<a href="upload.php">Upload</a>';
                echo '<a href="account.php">Account</a>';
                echo '<a href="logout.php">Log Out</a>';
            } else {
                echo '<a href="register.php">Register</a>';
                echo '<a href="login.php">Login</a>';
            }
            ?>
            
        </nav>
    </header>


    <div class="video-container">
    <?php 
       // Connect to the database
    $mysqli = new mysqli("localhost", "root", "", "niklas_stadie");

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    };

    $sql = "SELECT * FROM videos";
    $result = $mysqli->query($sql);

    if ($result -> num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<a href="watch.php?id=' . $row["id"] . '" class="video-item">';
            echo '<img src="' . $row["image_url"] . '" >';
            echo '<h2>' . $row["title"] . '</h2>';
            echo '<p>' . $row["creator"] . '</p>';
            echo '</a>';
        }
    }
    else {
        echo "0 results";
      }
    
    ?>
    </div>
</body>
<script src="script.js"></script>
</html>