<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Onboarding Screens</title>
    <link rel="stylesheet" href="css/onboarding.css">
</head>
<body>
    <div class="onboarding" id="onboarding1">
        <div class="content">
            <img src="assets/barbershop.png" alt="Onboard 1">
            <h1>Welcome to Salon Booking</h1>
            <p>Discover the best salons around you.</p>
        </div>
        <button onclick="showNext('onboarding2')">Next</button>
    </div>

    <div class="onboarding" id="onboarding2" style="display: none;">
        <div class="content">
            <img src="assets/barbershop.png" alt="Onboard 2">
            <h1>Book Your Appointment</h1>
            <p>Easy and fast booking with just a few clicks.</p>
        </div>
        <button onclick="showNext('onboarding3')">Next</button>
    </div>

    <div class="onboarding" id="onboarding3" style="display: none;">
        <div class="content">
            <img src="assets/barbershop.png" alt="Onboard 3">
            <h1>Enjoy Our Services</h1>
            <p>Experience the best salon services near you.</p>
        </div>
        <button onclick="getStarted()">Get Started</button>
    </div>

    <script>
        function showNext(nextId) {
            document.querySelectorAll('.onboarding').forEach(screen => {
                screen.style.display = 'none';
            });
            document.getElementById(nextId).style.display = 'flex';
        }

        function getStarted() {
            localStorage.setItem('onboardingComplete', 'true');
            window.location.href = 'signup.php';
        }
    </script>
</body>
</html>
