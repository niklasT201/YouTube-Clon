<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <title>Registre</title>
</head>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background: radial-gradient(circle, #000000, #202020);
        color: white;
    }

    .submit {
        margin-top: 20px;
        background-color: transparent;
        border: 1px solid white;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        margin-bottom: 10px;
    }

    .submit:hover {
        background-color: white;
        color: black;
    }
</style>
<body>

    <h2>User Registration</h2>
        <form action="register.php" method="post">
            <label for="name">Username:</label><br>
            <input type="text" id="name" name="name" required><br><br>
            
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br><br>
            
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            
            <label for="confirm_password">Confirm Password:</label><br>
            <input type="password" id="password_again" name="password_again" required><br><br>
            
            <button class="submit" type="submit">Register</button>
        </form>


    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $mysqli = new mysqli("localhost", "root", "", "niklas_stadie");

            // Check connection
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        };

        // Get data from form
        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $password_again = $_POST["password_again"];

        // Check if password and password_again match
        if ($password !== $password_again) {
            die("Error: Passwords do not match.");
        }

         // Check if the email already exists in the database
        $check_email_sql = "SELECT * FROM account WHERE email = ?";
        $check_stmt = $mysqli->prepare($check_email_sql);
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        die("Error: This email is already registered.");
    }


        $sql = "INSERT INTO account(name, email, password, password_again) VALUES (?, ?, ?, ?)";

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $password, $password_again); // Note: Adjust the data types and order as needed

        // Execute the statement
        if ($stmt->execute()) {
            echo "Registration successful!";
            echo '<form action="search.php">';
            echo '<button class="submit">Go Back</button>';
            echo '</form>';
        } else {
            echo "Error: " . $mysqli->error;
        }

        // Close the statement and connection
        $stmt->close();
        $mysqli->close();
    }
    ?>
    
</body>
</html>