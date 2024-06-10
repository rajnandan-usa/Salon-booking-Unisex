<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

include 'includes/config.php';

// Check if salon_id is provided in the URL
if (isset($_GET['salon_id'])) {
    $salon_id = intval($_GET['salon_id']); // Validate and sanitize input

    // Prepare and execute the query to fetch salon details
    $query = "SELECT name, phone, address, rating, image FROM salons WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $salon_id, PDO::PARAM_INT);
    $stmt->execute();
    $salon = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if salon details were found
    if ($salon) {
        $name = $salon['name'];
        $phone = $salon['phone'];
        $address = $salon['address'];
        $rating = $salon['rating'];
        $image = $salon['image'];

        // Prepare and execute the query to fetch salon services
        $servicesQuery = "SELECT id, name, description, price, image FROM services WHERE salon_id = :salon_id";
        $servicesStmt = $conn->prepare($servicesQuery);
        $servicesStmt->bindParam(':salon_id', $salon_id, PDO::PARAM_INT);
        $servicesStmt->execute();
        $services = $servicesStmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        die("Salon not found.");
    }
} else {
    die("No salon_id provided in the URL.");
}

// Close the database connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
    <link rel="stylesheet" href="css/services.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>

<body>
    <div class="header">
        <a href="home.php" class="back-arrow"><i class="material-icons">arrow_back</i></a>
        <h2 class="salon-name"><?php echo htmlspecialchars($name); ?></h2>
    </div>
    <div class="salon-info">
        <div class="salon-card">
            <!-- <img src="assets/<?php echo htmlspecialchars($image); ?>" alt="Salon Image"> -->
            <img src="assets/barbershop.png" alt="Salon Image">
            <div class="salon-details">
                <h3><?php echo htmlspecialchars($name); ?></h3>
                <p>Phone: <?php echo htmlspecialchars($phone); ?></p>
                <p>Address: <?php echo htmlspecialchars($address); ?></p>
                <p>Rating: <span class="rating"><?php echo htmlspecialchars($rating); ?></span></p>
            </div>
        </div>
    </div>
    <div class="services-list">
    <?php if (!empty($services)): ?>
        <?php foreach ($services as $service): ?>
            <a href="appointment.php?service_id=<?php echo $service['id']; ?>" class="service-card-link">
                <div class="service-card">
                    <img src="assets/cutting.png" alt="Service Image">
                    <div class="service-info">
                        <h3><?php echo htmlspecialchars($service['name']); ?></h3>
                        <p>Description: <?php echo htmlspecialchars($service['description']); ?></p>
                        <p>Price: $<?php echo htmlspecialchars($service['price']); ?></p>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No services available.</p>
    <?php endif; ?>
</div>


    <?php include('includes/footer.php'); ?>
</body>

</html>
