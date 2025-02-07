<?php
$servername="localhost";
$dbname="adnan";
$username="root";
$password="";


$conn=new mysqli($servername,$dbname,$username,$password);

if($conn->connect_error){
    die("connection failed: ".$conn->connect_error);
}
echo "connected successfully";

//getting form data

?>