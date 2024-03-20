<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <title>Video</title>
</head>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background: radial-gradient(circle, #000000, #202020);
        color: white;
    }

    .video-container {
        justify-content: center;
        display: flex;
        align-items: center;
        text-align: center;
        margin-top: 100px;
        flex-direction: column;
    }
    
    .video-container img{
       height: 50vb;
    }

    .video-container video {
        height: 50vh;
        display: none; /* Initially hide the video */
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
    <div class="video-container">
        <?php

    session_start();


        // Check if the 'id' parameter is set in the URL
        if(isset($_GET['id'])) {
            // Connect to the database
            $mysqli = new mysqli("localhost", "root", "", "niklas_stadie");

            // Check connection
            if ($mysqli->connect_error) {
                die("Connection failed: " . $mysqli->connect_error);
            }

            // Prepare SQL statement to fetch video details based on the id
            $stmt = $mysqli->prepare("SELECT * FROM videos WHERE id = ?");
            $stmt->bind_param("i", $_GET['id']);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if the query returned any result
            if ($result->num_rows > 0) {
                // Fetch the video details
                $row = $result->fetch_assoc();

                // Display the video details
                echo '<div class="video-details">';
                echo '<img src="' . $row["image_url"] . '" >';
                echo '<video controls>';
                echo '<source src="' . $row["video_url"] . '" type="video/mp4">';
                echo 'Your browser does not support the video tag.';
                echo '</video>';
                echo '<h2>' . $row["title"] . '</h2>';
                echo '<p>' . $row["creator"] . '</p>';
                echo '<p>' . $row["description"] . '</p>';
                echo '</div>';

                 // Show the delete button only if the user is logged in and is the creator of the video
                 if(isset($_SESSION['name']) && $_SESSION['name'] == $row["creator"]) {
                   /*  echo '<button class="submit delete-button" onclick="deleteVideo(' . $row["id"] . ')">Update Your Video</button>'; */
                    echo '<a href="edit.php?id=' . $row["id"] . '" class="submit">Edit Your Video</a>';
                
                }
            } else {
                echo "Video not found.";
            }

            // Close the database connection and statement
            $stmt->close();
            $mysqli->close();
        } else {
            echo "No video selected.";
        }
        ?>

        <div class="button-container">
            <button class="submit" onclick="showImage()">MP3</button>
            <?php
            if(!empty($row["video_url"])) {
                // Only show the Mp4 button if video_url exists
                echo '<button class="submit" onclick="showVideo()">Mp4</button>';
            }
            ?>
        </div>
    </div>


    <script>
    function showImage() {
        var image = document.querySelector('.video-details img');
        var video = document.querySelector('.video-details video');

        image.style.display = 'block';
        video.style.display = 'none';
    }

    function showVideo() {
        var image = document.querySelector('.video-details img');
        var video = document.querySelector('.video-details video');

        image.style.display = 'none';
        video.style.display = 'block';
    }

    
</script>
</body>
</html>