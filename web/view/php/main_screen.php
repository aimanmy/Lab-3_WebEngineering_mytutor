<?php
    session_start();
    if (!isset($_SESSION['sessionid'])) {
        echo "<script>alert('Session not available. Please login');</script>";
        echo "<script> window.location.replace('login.php')</script>";
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../js/menu.js" defer></script>

    <title>Welcome to MyTutor</title>
</head>

<body>
    <!-- Sidebar -->
    <div class="w3-sidebar w3-bar-block" style="display:none" id="mySidebar">
        <button onclick="w3_close()" class="w3-bar-item w3-button w3-large">Close &times;</button>
        <a href="#" class="w3-bar-item w3-button">Dashboard</a>
        <a href="#" class="w3-bar-item w3-button">Class Table</a>
        <a href="#" class="w3-bar-item w3-button">Book Class</a>
        <a href="#" class="w3-bar-item w3-button">Class Availability</a>
        <a href="login_page.php" class="w3-bar-item w3-button">Logout</a>
    </div>

    <div class="w3-pink">
        <button class="w3-button w3-pink w3-xlarge" onclick="w3_open()">☰</button>
        <div class="w3-container">
            <h3>MyTutor</h3>
            <p>

            </p>
        </div>
    </div>
    <div class="w3-bar w3-pink">
        <a href="newproduct.php" class="w3-bar-item w3-button w3-right">My Profile</a>
    </div>


    <footer class="w3-footer w3-center w3-bottom w3-pink">Mytutor</footer>

</body>

</html>