<?php
// Database connection variables
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "adnan";  // Make sure your database is named correctly

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data
$email = $_POST['email'];
$password = $_POST['password'];

// Prepare the query to select user by email
$query = "SELECT password FROM signup WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);  // Bind email as a string
$stmt->execute();
$stmt->store_result();

// Check if the user exists
if ($stmt->num_rows > 0) {
    $stmt->bind_result($hashedPassword);  // Bind the stored hashed password
    $stmt->fetch();

    // Verify the entered password against the hashed password in the database
    if (password_verify($password, $hashedPassword)) {
        // Successful login, redirect to home page
        
        header('Location: done.html'); 
        echo "Login successful!"; // Redirect to home or dashboard page
        exit();
    } else {
        // Invalid password
        header('Location: home.html');
    }
} else {
    // User not found
    echo "No user found with this email!";
}

// Close the prepared statement and connection
$stmt->close();
$conn->close();
?>
