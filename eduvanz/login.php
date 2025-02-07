<?php
session_start();

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

$email = $_POST['email'];
$password = $_POST['password'];

// Query to get the user from the database
$query = "SELECT * FROM signup WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// If user exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    // Verify the password
    if (password_verify($password, $user['password'])) {
        // Successful login, store user data in session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['fname'] = $user['firstname'];
        $_SESSION['lname'] = $user['lastname'];
        $_SESSION['email'] = $user['email'];

        // Redirect to profile page
        header('Location: profile.php');
        exit();
    } else {
        echo "Invalid password.";
    }
} else {
    echo "No user found with that email.";
}

$conn->close();
?>
