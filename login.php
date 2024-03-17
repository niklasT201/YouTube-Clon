


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <title>Login</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: radial-gradient(circle, #000000, #202020);
            color: white;
        }
    </style>
</head>
<body>
    <h2>User Login</h2>
    <form action="" method="post">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        
        <button type="submit">Login</button>
    </form>
    <?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Connect to the database
    $mysqli = new mysqli("localhost", "root", "", "niklas_stadie");

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Prepare SQL statement to fetch user details based on the provided email
    $sql = "SELECT * FROM account WHERE name='$name' AND email='$email' AND password='$password'";
    $result = $mysqli->query($sql);

    // Check if the query returned any result
    if ($result && $result->num_rows == 1) {
        // User credentials are correct, set session variables and redirect to dashboard or home page
        $row = $result->fetch_assoc();
        $_SESSION["user_id"] = $row["id"];
        $_SESSION["name"] = $row["name"]; // Add this line to set the name session variable
        $_SESSION["email"] = $row["email"];
        header("Location: index.php");
        exit;
    } else {
        // Invalid credentials
        $error = "Invalid credentials";
    }

    // Close the database connection
    $mysqli->close();
}
?>

</body>
</html>
