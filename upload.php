<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <title>Upload</title>
</head>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background: radial-gradient(circle, #202020, #000000);
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
    }

    .submit:hover {
        background-color: white;
        color: black;
    }

</style>
<body>

    <form action="upload.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
        
        <label for="title">Title:</label><br>
        <textarea id="title" name="title" style="width: 550px; height: 40px"></textarea><br><br>
        
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" style="height: 200px";></textarea><br><br>

        Select image to upload:
        <input type="file" name="image_url" id="image_url"><br><br>

        Select video to upload:
        <input type="file" name="video_url" id="video_url"><br><br>

        <button type="submit" class="submit">Submit</button>
    </form>

    <?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['name'])) {
    // Redirect the user to the login page if not logged in
    header("Location: login.php");
    exit;
}

// Set the creator to be the name of the logged-in account
$creator = $_SESSION['name'];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database
    $mysqli = new mysqli("localhost", "root", "", "niklas_stadie");

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Get data from form
    $title = $_POST["title"];
    $description = $_POST["description"];

    // File upload handling
    $imageTargetDir  = "uploads/"; // Directory where uploaded files will be stored
    $imageTargetFile = $imageTargetDir  . basename($_FILES["image_url"]["name"]); // Path to store the uploaded file

    // File upload handling for video
    $videoTargetDir = "uploads/"; // Directory where uploaded video files will be stored
    $videoTargetFile = $videoTargetDir . basename($_FILES["video_url"]["name"]); // Path to store the uploaded video file

    // Move uploaded file to the specified directory
    if (move_uploaded_file($_FILES["image_url"]["tmp_name"], $imageTargetFile) && move_uploaded_file($_FILES["video_url"]["tmp_name"], $videoTargetFile)) {
        // Prepare SQL statement
        $sql = "INSERT INTO videos (title, creator, description, image_url, video_url) VALUES (?, ?, ?, ?, ?)";

        // Prepare and bind parameters
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("sssss", $title, $creator, $description, $imageTargetFile, $videoTargetFile); 

        // Execute the statement
        if ($stmt->execute()) {
            echo "Data inserted successfully.";
            header("Location: index.php"); // Redirect to homepage
        } else {
            echo "Error: " . $sql . "<br>" . $mysqli->error;
        }

        // Close statement and database connection
        $stmt->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

    // Close the database connection
    $mysqli->close();
}
?>


<script>
    function validateForm() {
        var creator = document.getElementById("creator").value;
        var title = document.getElementById("title").value;
        var description = document.getElementById("description").value;

        if (creator === "" || title === "" || description === "") {
            alert("Please fill out all required fields (Creator, Title, Description).");
            return false;
        }
        return true;
    }
</script>
</body>
</html>

