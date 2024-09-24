<?php
// Database connection setup
$host = 'localhost'; // Database host
$dbname = 'train_reservation'; // Your database name
$username = 'root'; // Database username
$password = ''; // Database password

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for feedback messages
$login_error = '';
$login_success = '';

// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // SQL query to find the user
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?"; // Assuming 'users' table
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $input_username, $input_password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Login successful
        $login_success = "Login successful! Redirecting...";
        // Redirect to success page after 2 seconds
        header("refresh:2;url=loginsuccess.html");
    } else {
        // Login failed
        $login_error = "Invalid username or password.";
    }

    $stmt->close();
}

$conn->close();
?>
