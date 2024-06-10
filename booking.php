<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

include 'includes/config.php';

// Fetch bookings for the logged-in user
$user_id = $_SESSION['user_id'];
$query = "SELECT b.id, b.booking_date, b.booking_time, b.status, 
                 s.name AS service_name, sa.name AS salon_name 
          FROM bookings b 
          JOIN services s ON b.service_id = s.id 
          JOIN salons sa ON s.salon_id = sa.id 
          WHERE b.user_id = :user_id
          ORDER BY b.booking_date DESC, b.booking_time DESC";
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking List</title>
    <link rel="stylesheet" href="css/booking.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>

<body>
    <div class="header">
        <i class="material-icons back-icon" onclick="goBack()">arrow_back</i>
        <h1>Bookings</h1>
    </div>

    <div class="booking-list">
        <?php if (!empty($bookings)): ?>
            <?php foreach ($bookings as $booking): ?>
                <div class="booking-card">
                    <div class="booking-info">
                        <h3><?php echo htmlspecialchars($booking['salon_name']); ?></h3>
                        <p>Service: <?php echo htmlspecialchars($booking['service_name']); ?></p>
                        <p>Date: <?php echo htmlspecialchars($booking['booking_date']); ?></p>
                        <p>Time: <?php echo htmlspecialchars(date('h:i A', strtotime($booking['booking_time']))); ?></p>
                        <p>Status: <?php echo htmlspecialchars($booking['status']); ?></p>
                    </div>
                    <a href="booking-details.php?booking_id=<?php echo $booking['id']; ?>" class="salon-card-link">
                        <i class="material-icons">chevron_right</i>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No bookings found.</p>
        <?php endif; ?>
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
