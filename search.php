<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <title>YouTube Clon</title>
</head>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background: radial-gradient(circle, #000000, #202020);
        color: white;
    }

    header {
    background-color: rgb(39, 43, 43);
    }

    nav {
        display: flex;
        justify-content: center;
        text-align: center;
        align-items: center;
        background-color: rgb(39, 43, 43);
        width: 100%;
        height: 60px;
        font-size: 20px;
    }

    nav a {
        text-decoration: none;
        color: white;
        margin: 10px;
    }

    nav input {
        border-radius: 16px 0px 0px 16px;
        font-size: 20px;
        border: none;
    }

    header nav form {
        display: flex;
        align-items: center;
    }

    header nav form input[type="text"] {
        flex: 1;
    
    }

    nav button {
        height: 25px;
        border-radius: 0px 16px 16px 0px;
        border: none;
        width: 30px;
    }

    .card {
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 20px;
        width: 200px;
        margin-left: 20px;
    }

    
    .card-item {
        border-radius: 10px;
        padding: 20px;
        display: flex; /* Ensure the anchor takes up the entire space of the video item */
        flex-direction: column; /* Stack elements vertically inside the video item */
        text-align: center; /* Center align text */
        text-decoration: none; /* Remove default anchor styling */
        color: inherit; /* Inherit text color from parent */
    }

    .card-item h2, .card-item p {
        text-align: left; /* Align title and creator to the left */
        margin-left: -18px;
    }
    
    .card-item h2 {
        margin-bottom: 1px;  
    }

    .card-item img {
        height: 170px;
        width: 200px;
        margin-bottom: 10px; /* Add some space between image and text */
        border-radius: 10px;
        align-self: center; /* Center align image vertically within the video-item */
    }

</style>

<body>
    <header>
            <nav>
                <a href="index.php">Home</a>
                <form action="search.php">
                <input type="text" name="query">
                <button type="submit" class="submit"></button>
                </form>         
            </nav>
        </header>
        


    <?php
        // Check if the form is submitted with a search query
        if (isset($_GET['query'])) {
            // Sanitize the search query to prevent SQL injection and other attacks
            $search_query = htmlspecialchars($_GET['query']);

            // Connect to your database
            $mysqli = new mysqli("localhost", "root", "", "niklas_stadie");

            // Check connection
            if ($mysqli->connect_error) {
                die("Connection failed: " . $mysqli->connect_error);
            }

            // Prepare the SQL statement to search for the keyword in the 'title' column
            $sql = "SELECT * FROM videos WHERE title LIKE ?";
            $stmt = $mysqli->prepare($sql);

            // Bind the parameter to the SQL statement
            $search_param = "%" . $search_query . "%";
            $stmt->bind_param("s", $search_param);

            // Execute the SQL statement
            $stmt->execute();

            // Get the result set
            $result = $stmt->get_result();

            // Display search results
            if ($result->num_rows > 0) {
                echo "<h2>Search Results for: $search_query</h2>";
                while ($row = $result->fetch_assoc()) {
                    // Output the search results
                    echo '<div class="card">';
                    echo '<a href="watch.php?id=' . $row["id"] . '" class="card-item">';
                    echo '<img src="' . $row["image_url"] . '" >';
                    echo '<h2>' . $row["title"] . '</h2>';
                    echo '<p>' . $row["creator"] . '</p>';
                    echo '</a>';
                    echo "</div>";
                }
            } else {
                echo "<h2>No results found for: $search_query</h2>";
            }

            // Close the prepared statement and database connection
            $stmt->close();
            $mysqli->close();
        } else {
            // If the form is submitted without a search query, redirect the user back to the homepage or display an error message
            header("Location: index.php"); // Assuming index.php is your homepage
            exit();
        }
    ?>
</body>
</html>

