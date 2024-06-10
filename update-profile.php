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
    <title>Update Profile</title>
    <link rel="stylesheet" href="css/update-profile.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>

<body>
    <div class="header">
        <i class="material-icons back-icon" onclick="goBack()">arrow_back</i>
        <h1>Update Profile</h1>
    </div>

    <div class="profile-update-container">
        <div class="profile-card">
            <div class="profile-image-upload">
                <label for="profile-image-input">
                    <img src="assets/barbershop.png" id="profile-image-preview" alt="Profile Image">
                    <div class="upload-icon">
                        <i class="material-icons">camera_alt</i>
                    </div>
                </label>
                <input type="file" id="profile-image-input" accept="image/*" onchange="previewProfileImage(event)">
            </div>
            <form>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
                </div>
                <div class="button-group">
                    <button type="submit" class="update-button">Update</button>
                    <button type="button" class="cancel-button" onclick="goBack()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function goBack() {
            window.history.back();
        }

        function previewProfileImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('profile-image-preview');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

</html>
