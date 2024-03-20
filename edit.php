<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <title>YouTube - Edit Video</title>
</head>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background: radial-gradient(circle, #000000, #202020);
        color: white;
    }

    .edit-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 15%;
        font-size: 20px;
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
    <?php
    session_start();

    if(isset($_GET['id'])) {
        // Display form for updating or deleting the video
        echo '<div class="edit-item">';
        echo '<label for="Edit">Edit Your Video:</label><br>';
        echo '<a href="update.php?id=' . $_GET['id'] . '" class="submit">Update The Video</a>';
        echo '<a href="#" class="submit" onclick="deleteVideo(' . $_GET['id'] . ')">Delete The Video</a>';
        echo '</div>';
    } else {
        echo "No video selected.";
    }
    ?>

    <script>
        // Function to delete the video
        function deleteVideo(videoId) {
            if(confirm("Are you sure you want to delete this video?")) {
                window.location.href = "delete.php?id=" + videoId;
            }
        }
    </script>
</body>
</html>
