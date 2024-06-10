<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

include 'includes/config.php';

// Get booking details from the query string
$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;

// Fetch booking, service, and salon details
$query = "SELECT b.id, b.booking_date, b.booking_time, b.status, 
                 s.name AS service_name, s.price, sa.name AS salon_name 
          FROM bookings b 
          JOIN services s ON b.service_id = s.id 
          JOIN salons sa ON s.salon_id = sa.id 
          WHERE b.id = :booking_id AND b.user_id = :user_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    die("Booking not found.");
}

// Handle booking cancellation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_booking'])) {
    $update_query = "UPDATE bookings SET status = 'Cancelled' WHERE id = :booking_id AND user_id = :user_id";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
    $update_stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    
    if ($update_stmt->execute()) {
        $booking['status'] = 'Cancelled';
        $success_message = "Booking cancelled successfully.";
    } else {
        $error_message = "Failed to cancel booking. Please try again.";
    }
}

// Close the database connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
    <link rel="stylesheet" href="css/booking-details.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>

<body>
    <div class="header">
        <i class="material-icons back-icon" onclick="goBack()">arrow_back</i>
        <h1>Booking Details</h1>
    </div>

    <div class="booking-details-container">
        <div class="booking-card">
            <img src="assets/barbershop.png" alt="Salon Image" class="salon-image">
            <div class="booking-info">
                <h2><?php echo htmlspecialchars($booking['salon_name']); ?></h2>
                <p>Service: <?php echo htmlspecialchars($booking['service_name']); ?></p>
                <p>Price: $<?php echo htmlspecialchars($booking['price']); ?></p>
                <p>Date: <?php echo htmlspecialchars($booking['booking_date']); ?></p>
                <p>Time: <?php echo htmlspecialchars(date('h:i A', strtotime($booking['booking_time']))); ?></p>
                <p>Status: <?php echo htmlspecialchars($booking['status']); ?></p>

                <?php if ($booking['status'] != 'cancelled'): ?>
                    <form method="post" id="cancelForm">
                        <button type="button" class="cancel-button" onclick="confirmCancel()">Cancel Booking</button>
                        <input type="hidden" name="cancel_booking" value="1">
                    </form>
                <?php else: ?>
                    <p class="cancelled-message">This booking has been cancelled.</p>
                <?php endif; ?>
                
                <?php if (isset($success_message)): ?>
                    <p class="success-message"><?php echo htmlspecialchars($success_message); ?></p>
                <?php elseif (isset($error_message)): ?>
                    <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function goBack() {
            window.history.back();
        }

        function confirmCancel() {
            if (confirm("Are you sure you want to cancel this booking?")) {
                document.getElementById('cancelForm').submit();
            }
        }
    </script>

</body>

</html>
