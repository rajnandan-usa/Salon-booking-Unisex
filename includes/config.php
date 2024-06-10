<?php
// $servername = "localhost";
// $username = "u243565452_unisex_salon"; // Your database username
// $password = "/7c1w1SSg"; // Your database password
// $dbname = "u243565452_unisex_salon";

$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "salon_booking";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
