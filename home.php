<?php

include 'includes/config.php';

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
    <title>Salon List</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.2.4/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>

<body>
    <div class="header">
        <div class="search-bar">
            <input type="text" placeholder="Search for salons...">
            <i class="material-icons">search</i>
        </div>
        <div class="profile-icon" onclick="toggleProfileMenu()">
            <i class="material-icons">account_circle</i>
        </div>
        <div id="profile-menu" class="profile-menu">
            <ul>
                <li><a href="booking.php">Booking</a></li>
                <li><a href="update-profile.php">Update Profile</a></li>
                <li><a href="change-password.php">Change Password</a></li>
                <li><a href="privacy-policy.php">Privacy and Policy</a></li>
                <li><a href="term-condition.php">Terms & Conditions</a></li>
                <li><a href="logout.php">Logout</a></li>
                <li><a href="#">Delete Account</a></li>
            </ul>
        </div>
    </div>

    <!-- Swiper Slider -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><img src="assets/2.png" alt="Slider Image 1"></div>
            <div class="swiper-slide"><img src="assets/2.png" alt="Slider Image 2"></div>
            <div class="swiper-slide"><img src="assets/2.png" alt="Slider Image 3"></div>
            <!-- Add more slides as needed -->
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>

    <div class="salon-list">
        <!-- Example Salon Cards -->
        <?php
        try {
            $stmt = $conn->prepare("SELECT * FROM salons");
            $stmt->execute();

            // Fetch all the salon records
            $salons = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Output the salon list
            foreach ($salons as $salon) {
                echo '<a href="services.php?salon_id=' . $salon['id'] . '" class="salon-card-link">';
                echo '<div class="salon-card">';
                echo '<img src="assets/barbershop.png" alt="Salon Image">';
                echo '<div class="salon-info">';
                echo '<h3>' . $salon['name'] . '</h3>'; // Assuming 'name' is the column name for salon name
                echo '<p>' . $salon['phone'] . '</p>'; // Assuming 'phone' is the column name for salon phone
                echo '<p><a href="' . $salon['location'] . '" class="salon-card-location">Get Directions</a></p>';
                echo '<p><span class="rating">';
                // Assuming 'rating' is the column name for salon rating (1 to 5)
                for ($i = 0; $i < $salon['rating']; $i++) {
                    echo '<span class="star">★</span>';
                }
                for ($i = $salon['rating']; $i < 5; $i++) {
                    echo '<span class="star">☆</span>';
                }

                echo '</span></p>';
                echo '</div>';
                echo '<i class="material-icons">chevron_right</i>';
                echo '</div>';
                echo '</a>';
            }
        } catch (PDOException $e) {
            // Handle database connection errors
            echo "Connection failed: " . $e->getMessage();
        }
        ?>
    </div>
    <?php include('includes/footer.php'); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.2.4/swiper-bundle.min.js"></script>
    <script>
        function toggleProfileMenu() {
            var menu = document.getElementById('profile-menu');
            menu.classList.toggle('show');
        }

        window.onclick = function(event) {
            if (!event.target.matches('.profile-icon, .profile-icon *')) {
                var menu = document.getElementById('profile-menu');
                if (menu.classList.contains('show')) {
                    menu.classList.remove('show');
                }
            }
        }

        // Initialize Swiper
        var swiper = new Swiper('.swiper-container', {
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });

        // Add interactive stars functionality
        const stars = document.querySelectorAll('.star');
        stars.forEach((star, index) => {
            star.addEventListener('click', () => {
                stars.forEach((s, i) => {
                    if (i <= index) {
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                    }
                });
            });
        });
    </script>
</body>

</html>