<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "adnan";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";

// Collect form data
$fname = $_POST['firstname'];
$lname = $_POST['lastname'];
$email = $_POST['email'];
$password = $_POST['password'];
$conpassword = $_POST['confirmedpassword'];


if ($password !== $conpassword) {
    echo "Passwords do not match!";
    exit();
}


$query = "SELECT * FROM signup WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if user already exists
if ($result->num_rows > 0) {
    // User found, redirect to login page
    header('Location: login.html');
    exit();
} else {
    // User does not exist, hash the password and insert new user into the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $insert_query = "INSERT INTO signup (firstname, lastname, email, password) VALUES (?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param("ssss", $fname, $lname, $email, $hashedPassword);
    $insert_stmt->execute();

    // Check if insertion was successful
    if ($insert_stmt->error) {
        echo "Error: " . $insert_stmt->error;
        exit();
    }

    // Redirect to login page after successful signup
    header('Location: login.html'); // Corrected redirection path
    exit();
}

$conn->close();
?>
