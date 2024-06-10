<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Splash Screen</title>
    <link rel="stylesheet" href="css/splash.css">
</head>
<body>
    <div class="splash-screen">
        <div class="logo">
            <img src="assets/barbershop.png" alt="App Logo">
        </div>
        <h1>Salon Booking</h1>
    </div>

    <script>
        setTimeout(() => {
            if (localStorage.getItem('onboardingComplete')) {
                window.location.href = 'signup.php';
            } else {
                window.location.href = 'onboarding1.php';
            }
        }, 3000);
    </script>    
</body>
</html>
