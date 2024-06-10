<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

include 'includes/config.php';

// Get service details from the query string
$service_id = isset($_GET['service_id']) ? intval($_GET['service_id']) : 0;

// Fetch service and salon details
$query = "SELECT s.name AS service_name, s.duration, s.salon_id, se.name AS salon_name 
          FROM services s 
          JOIN salons se ON s.salon_id = se.id 
          WHERE s.id = :service_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':service_id', $service_id, PDO::PARAM_INT);
$stmt->execute();
$service = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$service) {
    die("Service not found.");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $customer_name = $_POST['customer_name'];
    $user_id = $_SESSION['user_id'];
    $salon_id = $service['salon_id']; // Get the salon ID from the fetched service details

    // Insert the appointment into the database
    $query = "INSERT INTO bookings (user_id, service_id, salon_id, booking_date, booking_time, customer_name) 
              VALUES (:user_id, :service_id, :salon_id, :appointment_date, :appointment_time, :customer_name)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':service_id', $service_id, PDO::PARAM_INT);
    $stmt->bindParam(':salon_id', $salon_id, PDO::PARAM_INT);
    $stmt->bindParam(':appointment_date', $appointment_date);
    $stmt->bindParam(':appointment_time', $appointment_time);
    $stmt->bindParam(':customer_name', $customer_name);

    if ($stmt->execute()) {
        header("Location: success.php");
        exit();
    } else {
        $error_message = "Failed to book appointment. Please try again.";
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
    <title>Appointment Booking</title>
    <link rel="stylesheet" href="css/appointment.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>

<body>
    <div class="header">
        <a href="services.php" class="back-arrow"><i class="material-icons">arrow_back</i></a>
        <h2 class="service-name"><?php echo htmlspecialchars($service['service_name']); ?></h2>
    </div>

    <div class="booking-details">
        <div class="salon-service-info">
            <h3><?php echo htmlspecialchars($service['salon_name']); ?></h3>
            <p>Service: <?php echo htmlspecialchars($service['service_name']); ?></p>
            <p>Duration: <?php echo htmlspecialchars($service['duration']); ?> minutes</p>
        </div>
        <div class="appointment-form">
            <?php if (!empty($success_message)): ?>
                <p class="success-message"><?php echo $success_message; ?></p>
            <?php elseif (!empty($error_message)): ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form method="post">
                <input type="date" name="appointment_date" id="appointment-date" required>
                <input type="time" name="appointment_time" id="appointment-time" required>
                <input type="text" name="customer_name" id="customer-name" placeholder="Your Name" required>
                <button type="submit">Book Appointment</button>
            </form>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>
</body>

</html>
