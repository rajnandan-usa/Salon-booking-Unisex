<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

include 'includes/config.php';

// Get user details
$user_id = $_SESSION['user_id'];

$query = "SELECT name, phone, email FROM users WHERE id = :user_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

// Get booking statistics
$query = "SELECT 
             (SELECT COUNT(*) FROM bookings WHERE user_id = :user_id) AS total_bookings, 
             (SELECT COUNT(*) FROM bookings WHERE user_id = :user_id AND status = 'Cancelled') AS cancelled_bookings";
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$stats = $stmt->fetch(PDO::FETCH_ASSOC);

// Close the database connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>

<body>
    <div class="header">
        <i class="material-icons back-icon" onclick="goBack()">arrow_back</i>
        <h1>Profile</h1>
    </div>

    <div class="profile-container">
        <div class="profile-image">
            <img src="assets/barbershop.png" alt="Profile Image">
        </div>

        <div class="profile-stats">
            <div class="stats-box">
                <h3><?php echo htmlspecialchars($stats['total_bookings']); ?></h3>
                <p>Total Bookings</p>
            </div>
            <div class="stats-box">
                <h3><?php echo htmlspecialchars($stats['cancelled_bookings']); ?></h3>
                <p>Cancelled Bookings</p>
            </div>
        </div>
        
        <div class="profile-details">
            <h2><?php echo htmlspecialchars($user['name']); ?></h2>
            <p>Phone: <?php echo htmlspecialchars($user['phone']); ?></p>
            <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>
