<?php
session_start();
include_once("dbconnect.php");
if (isset($_SESSION['sessionid'])) {
    $user_email = $_SESSION['email'];
    $user_name = $_SESSION['name'];
    $user_phone = $_SESSION['phone'];
}else{
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('login_page.php')</script>";
}

if (isset($_GET['tutorid'])) {
    $tutorid = $_GET['tutorid'];
    $sqltutors= "SELECT * FROM tbl_tutors WHERE tutor_id = '$tutorid'";
    $stmt = $conn->prepare($sqltutors);
    $stmt->execute();
    $number_of_result = $stmt->rowCount();
    if ($number_of_result > 0) {
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rows = $stmt->fetchAll();
    } else {
        echo "<script>alert('Product not found.');</script>";
        echo "<script> window.location.replace('tutor_page.php')</script>";
    }
} else {
    echo "<script>alert('Page Error.');</script>";
    echo "<script> window.location.replace('tutor_page.php')</script>";
}

$sqlsubTutor= "SELECT subject_name FROM tbl_subjects WHERE tutor_id = '$tutorid'";
    $stmt = $conn->prepare($sqlsubTutor);
    $stmt->execute();
    $number_of_result = $stmt->rowCount();
    if ($number_of_result > 0) {
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rows2 = $stmt->fetchAll();
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
    <link rel="stylesheet" href="../css/stylepage.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../js/menu.js" defer></script>
    

    <title>Welcome to MyTutor</title>
</head>

<body>
    <!-- Sidebar -->
    <div class="w3-sidebar w3-bar-block" style="display:none" id="mySidebar">
        <button onclick="w3_close()" class="w3-bar-item w3-button w3-large w3-sans-serif"><i class="material-icons" style="font-size:24px">highlight_off</i> Close &times;</button>
        <a href="main_screen.php" class="w3-bar-item w3-button w3-sans-serif"><i class="material-icons" style="font-size:24px">school</i> Courses</a>
        <a href="tutor_page.php" class="w3-bar-item w3-button w3-sans-serif"><i class="material-icons" style="font-size:24px">recent_actors</i> Tutors</a>
        <a href="#" class="w3-bar-item w3-button w3-sans-serif"><i class="material-icons" style="font-size:24px">subscriptions</i> Subscription</a>
        <a href="#" class="w3-bar-item w3-button w3-sans-serif"><i class="material-icons" style="font-size:24px">account_circle</i> Profile</a>
        <a href="login_page.php" class="w3-bar-item w3-button w3-sans-serif"><i class="material-icons" style="font-size:24px">exit_to_app</i> Logout</a>
    </div>

    <div class="w3-pink">
        <button class="w3-button w3-pink w3-xlarge" onclick="w3_open()">☰</button>
        <div class="w3-container ">
            <div class="w3-bar w3-pink">
                <a href="tutor_page.php" class="w3-bar-item w3-button w3-left w3-cursive w3-black">Back</a>
                <h3 class="w3-cursive w3-center">Tutor Details</h3><br>
            </div>
        </div>
    </div>

    <div >
        <?php
        $i = 0;
        foreach ($rows as $tutor){
            $i++;
            $tutorid = $tutor['tutor_id'];
            $tutorname = ($tutor['tutor_name']);
            $tutoremail = $tutor['tutor_email'];
            $tutorphone = $tutor['tutor_phone'];
            $tutordesc = $tutor['tutor_description'];

            echo "<div class='w3-padding w3-center'> <img class='w3-image resimg' src=../../../assets/tutors/$tutorid.jpg" .
            " onerror=this.onerror=null;"
            . " ></div><hr>";
            echo "<div class='w3-container w3-padding-large'><h4><b>$tutorname</b></h4>";
            echo "<div class='w3-container w3-cursive'><p><b>Tutor Email:</b> $tutoremail<br><b>Tutor Phone Number:</b> $tutorphone<br><b>Tutor Description:</b> $tutordesc<br></p></div>
            </div>";
        }
        echo "<div class='w3-cursive'><p><b>Subject Tutoring:</b></p></div>
            </div>";
        $z = 0;
        foreach ($rows2 as $sub){
            $z++;
            $subTutor = $sub['subject_name'];
            echo "<p class='w3-cursive'>$subTutor</p>";
        }
        ?>
    </div>
    <footer class="w3-footer w3-center w3-bottom w3-pink cursive">Mytutor</footer>

</body>

</html>