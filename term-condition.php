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
    <title>Terms and Conditions</title>
    <link rel="stylesheet" href="css/term-condition.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>

<body>
    <div class="header">
        <i class="material-icons back-icon" onclick="goBack()">arrow_back</i>
        <h1>Terms and Conditions</h1>
    </div>

    <div class="terms-conditions-container">
        <div class="terms-conditions-card">
            <h2>Terms and Conditions</h2>
            <p>These terms and conditions outline the rules and regulations for the use of our website. By accessing this website we assume you accept these terms and conditions in full. Do not continue to use the website if you do not accept all of the terms and conditions stated on this page.</p>

            <h3>1. License</h3>
            <p>Unless otherwise stated, we and/or our licensors own the intellectual property rights for all material on this website. All intellectual property rights are reserved. You may view and/or print pages from the website for your own personal use subject to restrictions set in these terms and conditions.</p>

            <h3>2. User Comments</h3>
            <p>Certain parts of this website offer the opportunity for users to post and exchange opinions, information, material, and data ('Comments'). We do not screen, edit, publish or review Comments prior to their appearance on the website and Comments do not reflect our views or opinions.</p>

            <h3>3. Hyperlinking to our Content</h3>
            <p>The following organizations may link to our Website without prior written approval: Government agencies, Search engines, News organizations, and Online directory distributors.</p>

            <h3>4. Iframes</h3>
            <p>Without prior approval and express written permission, you may not create frames around our Webpages or use other techniques that alter in any way the visual presentation or appearance of our Website.</p>

            <h3>5. Content Liability</h3>
            <p>We shall have no responsibility or liability for any content appearing on your website. You agree to indemnify and defend us against all claims arising out of or based upon your website.</p>

            <h3>6. Reservation of Rights</h3>
            <p>We reserve the right at any time and in its sole discretion to request that you remove all links or any particular link to our website. You agree to immediately remove all links to our website upon such request.</p>

            <h3>7. Removal of links from our website</h3>
            <p>If you find any link on our website or any linked website objectionable for any reason, you may contact us about this. We will consider requests to remove links but will have no obligation to do so or to respond directly to you.</p>

            <h3>8. Disclaimer</h3>
            <p>To the maximum extent permitted by applicable law, we exclude all representations, warranties, and conditions relating to our website and the use of this website. Nothing in this disclaimer will limit or exclude our or your liability for death or personal injury resulting from negligence, limit or exclude our or your liability for fraud or fraudulent misrepresentation, or limit any of our or your liabilities in any way that is not permitted under applicable law.</p>
        </div>
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
