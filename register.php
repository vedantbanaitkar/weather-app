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
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"]; // Note: Password is stored in plaintext
    $city = $_POST["city"];

    // Prepare SQL statement to insert user data into the database
    $sql = "INSERT INTO userinfo (`Name`, `Email-id`, `Password`, `City`) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $password, $city);

    // Execute the statement
    if ($stmt->execute()) {
        // Registration successful
        header("Location: login.php");
        exit();
    } else {
        // Registration failed
        echo "Error: " . $sql . "<br>" . $conn->error;
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
    <title>Register</title>
    <link rel="stylesheet" href="styles.css"> <!-- Use the same styles.css file as the index page -->
    <style>
        /* Style for the whole page */
        body {
            background-color: #7aa2e3; /* Use the background color from the index.php page */
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
        }

        /* Style for the registration container */
        .container {
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 10px;
            width: 400px;
            text-align: center;
        }

        /* Style for the registration form */
        #registerForm {
            margin-bottom: 20px;
        }

        /* Style for input fields */
        /* Style for input fields */
        input[type="text"],
        input[type="password"],
        input[type="email"],
        button[type="submit"] {
            width: 400px;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 16px;
        }

        /* Style for register button */
        button[type="submit"] {
            margin-top: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        /* Style for login link */
        .login-link {
            font-size: 14px;
            color: blue;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form id="registerForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="city" placeholder="City" required>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a class="login-link" href="login.php">Login here</a></p>
    </div>
</body>
</html>
