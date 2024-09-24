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
$signup_error = '';
$signup_success = '';

// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Check if passwords match
    if ($password != $confirm_password) {
        $signup_error = "Passwords do not match!";
    } else {
        // Check if username or email already exists in the database
        $sql_check = "SELECT * FROM userers WHERE username = ? OR email = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("ss", $username, $email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            $signup_error = "Username or email already exists!";
        } else {
            // Hash the password before saving
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user into the database
            $sql_insert = "INSERT INTO users (name, email, username, password) VALUES (?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("ssss", $name, $email, $username, $hashed_password);

            if ($stmt_insert->execute()) {
                $signup_success = "Signup successful! Redirecting to login...";
                // Redirect to login page after 3 seconds
                header("refresh:3;url=login.html");
            } else {
                $signup_error = "Error: Could not register. Please try again.";
            }

            $stmt_insert->close();
        }

        $stmt_check->close();
    }
}

$conn->close();
?>
