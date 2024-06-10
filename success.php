<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Success</title>
    <link rel="stylesheet" href="css/success.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
    <div class="header">
        <a href="home.php" class="back-arrow"><i class="material-icons">arrow_back</i></a>
    </div>
    <div class="content">
        <h2>Appointment Booked Successfully!</h2>
        <button onclick="redirectToBookings()">View Bookings</button>
    </div>

    <?php include('includes/footer.php'); ?>

    <script>
        function redirectToBookings() {
            window.location.href = 'booking.php'; // Replace with the actual booking list page
        }
    </script>
</body>
</html>
