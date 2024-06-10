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
    <title>Change Password</title>
    <link rel="stylesheet" href="css/change-password.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>

<body>
    <div class="header">
        <i class="material-icons back-icon" onclick="goBack()">arrow_back</i>
        <h1>Change Password</h1>
    </div>

    <div class="profile-update-container">
        <div class="profile-card">
            <form>
                <div class="form-group">
                    <label for="name">Current Password</label>
                    <input type="text" id="name" name="name" placeholder="Enter your Current password" required>
                </div>
                <div class="form-group">
                    <label for="email">New Password</label>
                    <input type="password" id="email" name="email" placeholder="Enter new password" required>
                </div>
                <div class="form-group">
                    <label for="phone">Confirm Password</label>
                    <input type="password" id="phone" name="phone" placeholder="Enter confirm password" required>
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
