<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "train_reservation";  // Your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Get form data
    $from = $_POST['from'];
    $to = $_POST['to'];
    $date = $_POST['date'];

    // Sanitize input to prevent SQL injection
    $from = $conn->real_escape_string($from);
    $to = $conn->real_escape_string($to);
    $date = $conn->real_escape_string($date);

    // Update the SQL query with the correct column names
    $sql = "INSERT INTO trains (from_city, to_city, journey_date) VALUES ('$from', '$to', '$date')";

    // Execute query
    if ($conn->query($sql) === TRUE) {
        echo "Searched successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();
?>
