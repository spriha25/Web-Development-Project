<?
$servername = "localhost";
$database = "u448101502_wap";
$username = "u448101502_wap";
$password = "hp;2;5SxL6#A";


 
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}