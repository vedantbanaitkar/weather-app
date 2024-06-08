<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Establish database connection
$servername = "localhost"; // Change this to your database server name
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$database = "weather app"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data from the database
$user_id = $_SESSION["user_id"];
$sql = "SELECT * FROM userinfo WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if user data exists
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $username = $row['Name'];
    $email = $row['Email-id'];
    $city = $row['City'];
} else {
    // Handle error if user data is not found
    $error = "User data not found";
}

// Process logout
if (isset($_POST["logout"])) {
    // Destroy session
    session_destroy();
    // Redirect to login page
    header("Location: login.php");
    exit;
}

// Close database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <script src="https://kit.fontawesome.com/e22178dd4a.js" crossorigin="anonymous"></script>
    <style>
        /* Add your CSS styles here */
        .container {
    text-align: center;
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100vh; /* Set the container height to full viewport height */
}

.card {
    background-color: #7aa2e3;
    width: 400px; /* Adjust the width of the card as needed */
    padding: 20px;
    /* background-color: #f0f0f0; Light gray background */
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Light shadow */
    height: 200px;
}

.user-icon {
    width: 200px; /* Adjust the size as needed */
    height: 200px; /* Adjust the size as needed */
    border-radius: 50%; /* Make it round */
    margin-bottom: 20px;
}

.profile-info p {
    margin-bottom: 10px;
}

    </style>
</head>
<body>
   <div class="container">
    <div class="card">
        <h2>Welcome, <?php echo $username; ?></h2>
        <i class="fa-solid fa-user"></i>
        <div class="profile-info">
            <p><strong>Email:</strong> <?php echo $email; ?></p>
            <p><strong>City:</strong> <?php echo $city; ?></p>
        </div>
        
        <!-- Logout form -->
        <form method="post">
            <button type="submit" name="logout">Logout</button>
        </form>
    </div>
</div>


    <script>
        // JavaScript code for updating profile
    </script>
</body>
</html>
