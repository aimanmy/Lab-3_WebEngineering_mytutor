<?php
if(isset($_POST["submit"])){
    include 'dbconnect.php';
    $email = $_POST["email"];
    $pass = sha1($_POST["password"]);
    $sqllogin = "SELECT * FROM table_registeration WHERE user_email ='$email' AND user_password = '$pass'";
    $stmt = $conn->prepare($sqllogin);
    $stmt->execute();
    $number_of_rows = $stmt->fetchColumn();

    if($number_of_rows > 0){
        session_start();
        $_SESSION["sessionid"] = session_id();
        $_SESSION["email"] = $email ;
        echo "<script>alert('Login Successful');</script>";
        echo "<script>window.location.replace('main_screen.php')</script>";
    }else{
        echo "<script>alert('Login Failed')</script>";
        echo "<script> window.location.replace('login_page.php')</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>Login</title>
    <script src = "../js/script.js" ></script>
    
</head>

<style>
    @media screen and (min-width: 1920px) {
        body{
            max-width: 60%;
            margin: auto;
        }
        
    }
    @media screen and (min-width: 601px) {
        .form-container{
            max-width: 500px;
            margin: auto;
        }
        
    }
    .responsive{
            max-width: 100%;
            height: 100%;
            background-size: auto;
    } 

    .responsive2{
            max-width: 100%;
            height: 100%;
            background-size: auto;
    } 

</style>

<body onload = "loadCookies()">
    
    <header class = "w3-header w3-display-container w3-padding-32 w3-center">
        <image src="header.png" class="responsive">
    </header>

    <div class = "w3-container w3-padding-64 form-container">
        <div class = "w3-card-4">
            <div class = "w3-container w3-pink">
                <h2>Login</h2>
            </div>
            <form  name="loginForm" class="w3-container" action="login_page.php" method="post">
                <p>
                    <a href= "register_page.php"class="w3-btn w3-round w3-pink w3-bar-block w3-right" name="submit">Register</a>
                </p>
                
                <p><br>
                    <label class = "w3-text-pink"><b>Email</b></label>
                    <input class = "w3-input w3-border w3-round" name="email" type="email" id= "idemail" placeholder = "Your Email" required>
                </p>
                <p>
                    <label class="w3-text-pink"><b>Password</b></label>
                    <input class = "w3-input w3-border w3-round" name ="password" type="password" id="idpass" placeholder = "Your Password" required>
                </p>
                <p>
                    <input class="w3-check" name = "rememberme" type="checkbox" id="idremember" onclick="rememberMe()">
                    <label>Remember Me</label>
                </p>
                <p>
                    <button class="w3-btn w3-round w3-pink w3-block" name="submit">Login</button>
                </p>
            </form>
        </div>
    </div>

    <div id = "cookieNotice" class = "w3-right w3-block" style = "display: none;">
        <div class = "w3-red">
            <h4>Cookie Consent</h4>
            <p> This Website Uses Cookies or Similar Technologies, to Enchance Your Browsing Experience and Provide Personalized Recommendations. By Continuing to Use Our Website You Agree to Our
            <a style = "color:#115cfa;" href="/privacy-policy">Privacy Policy</a></p>
            <div class="w3-button">
                <button onclick = "acceptCookieConsent();">Accept</button>
            </div>
        </div>
        <br><br></div>
    
        <footer class="w3-footer w3-center w3-bottom w3-pink">MyTutor</footer>

</body>

<script>
    let cookie_consent = getCookie("user_cookie_consent");
    if (cookie_consent != "") {
        document.getElementById("cookieNotice").style.display = "none";
    } else {
        document.getElementById("cookieNotice").style.display = "block";
    }
</script>

</html>
