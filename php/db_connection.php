<?php
$servername = "127.0.0.1"; 
$username = "root";        
$password = "123123";      
$dbname = "kd_academy";  
$port = 3307;              

$conn = new mysqli($servername, $username, $password, $dbname, $port);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully to the kd_academy database!<br>";
    echo "Server version: " . $conn->server_info; 
}