<?php
$servername="localhost";
$username="root";
$password="";
$database="adnan";

$conn=new mysqli($servername,$username,$password,$database);

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
echo "connected successfully";


$feedback=$_POST['feedback'];
$email=$_POST['email'];

$sql="insert into feedback values('$feedback','$email')";

if ($conn->query($sql) === TRUE) {
    echo "Thank you for your feedback!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


// Close the connection
$conn->close();






?>