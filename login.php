<?php
session_start();

// Database connection
$servername = "localhost"; // Change this if your database server is different
$username = "root"; // Change this if your database username is different
$password = ""; // Change this if your database password is different
$dbname = "weather app"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $usernameOrEmail = $_POST["usernameOrEmail"];
    $password = $_POST["password"];

    // Prepare SQL statement to fetch user data
    $sql = "SELECT * FROM userinfo WHERE `Name` = ? OR `Email-id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);

    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows == 1) {
        // User found, verify password
        $row = $result->fetch_assoc();

        // Check if the entered password matches the stored plaintext password
        if ($password == $row["Password"]) {
            // Password is correct, store user data in session and redirect to dashboard
            $_SESSION["user_id"] = $row["ID"]; // Assuming user ID is stored in "ID" column
            header("Location: index.php");
            exit();
        } else {
            // Incorrect password
            $error = "Incorrect password";
        }
    } else {
        // User not found
        $error = "User not found";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css"> <!-- Use the same style.css file as the index page -->
    <style>
        /* Center login form vertically and horizontally */
        .outer {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #7aa2e3;
        }

        /* Style for login container */
        .container {
            text-align: center; /* Center align login title */
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 15px;
            width: 400px;
            background-color: white;
            
        }

        /* Style for login form */
        #loginForm {
            margin-top: 20px;
        }

        /* Style for login input fields */
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        /* Style for login button */
        button[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Style for error message */
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="outer">
        <div class="container">
            <h2>Login</h2>
            <form id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="text" name="usernameOrEmail" placeholder="Username or Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <?php if (isset($error)) { ?>
                <p class="error"><?php echo $error; ?></p>
            <?php } ?>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
    <script src="script.js"></script>
    <script>
        function redirectToProfile() {
            window.location.href = "profile.php"; // Redirect to the profile page
        }
    </script>
</body>
</html>
