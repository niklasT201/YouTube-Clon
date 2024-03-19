<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <title>Account</title>
</head>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background: radial-gradient(circle, #000000, #202020);
        color: white;
    }

    .account-info {
        margin: 0 auto;
        width: 300px;
        border: 2px solid white;
        padding: 20px;
        border-radius: 10px;
        margin-top: 15%;
    }

    .account-info h2 {
        margin-bottom: 20px;
    }

    .account-info p {
        margin-bottom: 10px;
    }

    .account-info a {
        color: #2196F3;
        text-decoration: none;
    }

    .account-info a:hover {
        text-decoration: underline;
    }
</style>
<body>
<div class="account-info">
        <h2>Account Information</h2>
        <?php
        // Start the session to access session variables
        session_start();

        // Check if the user is logged in (i.e., if the session variable is set)
        if(isset($_SESSION['name'])) {
            // Display user's account information
            echo "<p><strong>Username:</strong> " . $_SESSION['name'] . "</p>";
            echo "<p><strong>Email:</strong> " . $_SESSION['email'] . "</p>";
            // Add additional account information as needed

            echo '<p><a href="index.php">HOME</a></p>'; // Logout link
        } else {
            // Redirect the user to the login page if not logged in
            header("Location: login.php");
            exit();
        }
        ?>
    </div>
    
</body>
</html>