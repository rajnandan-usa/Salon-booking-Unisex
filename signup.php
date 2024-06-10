<?php
include 'includes/config.php';

$modalMessage = '';
$modalType = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate email and phone number
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $modalMessage = "Invalid email format.";
        $modalType = "error";
    } elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
        $modalMessage = "Phone number must be 10 digits.";
        $modalType = "error";
    } elseif ($password !== $confirm_password) {
        $modalMessage = "Passwords do not match.";
        $modalType = "error";
    } else {
        try {
            // Check if email or phone already exists
            $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email OR phone = :phone");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->execute();
            $result = $stmt->fetchColumn();

            if ($result > 0) {
                $modalMessage = "Email or phone number already exists.";
                $modalType = "error";
            } else {
                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                // Insert new user
                $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (:name, :email, :phone, :password)");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':password', $hashed_password);
                $stmt->execute();
                $modalMessage = "Registration successful.";
                $modalType = "success";
            }
        } catch(PDOException $e) {
            $modalMessage = "Error: " . $e->getMessage();
            $modalType = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/signup.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
    <div class="signup-container">
        <div class="card">
            <h2>Create Account</h2>
            <form method="post">
                <div class="input-field">
                    <i class="material-icons">person</i>
                    <input type="text" name="name" placeholder="Name" required>
                </div>
                <div class="input-field">
                    <i class="material-icons">email</i>
                    <input type="email" name="email" placeholder="Email (Valid Email)" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                </div>
                <div class="input-field">
                    <i class="material-icons">phone</i>
                    <input type="text" name="phone" placeholder="Phone (10 Digit)" required pattern="[0-9]{10}">
                </div>
                <div class="input-field">
                    <i class="material-icons">lock</i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="input-field">
                    <i class="material-icons">lock</i>
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                </div>
                <button type="submit" class="btn">Sign Up</button>
            </form>
            <p>Already have an account? <a href="signin.php">Sign In</a></p>
        </div>
    </div>

    <!-- The Modal -->
    <div id="messageModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="modalMessage" class="<?php echo $modalType; ?>"><?php echo $modalMessage; ?></p>
        </div>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("messageModal");
        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];
        
        // Show the modal if there is a message
        <?php if ($modalMessage != ''): ?>
            modal.style.display = "block";
        <?php endif; ?>
        
        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }
        
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
