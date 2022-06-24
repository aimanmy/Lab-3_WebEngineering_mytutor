<?php
session_start();
include_once("dbconnect.php");
if (isset($_SESSION['sessionid'])) {
    $user_id = $_SESSION['id'];
    $user_email = $_SESSION['email'];
    $user_name = $_SESSION['name'];
    $user_phone = $_SESSION['phone'];
}else{
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('login.php')</script>";
}

if (isset($_GET['submit'])) {
    $operation = $_GET['submit'];
    if ($operation == 'search') {
        $search = $_GET['search'];
        $sqlsubjects = "SELECT * FROM tbl_subjects WHERE subject_name LIKE '%$search%'";
    }
} else {
    $sqlsubjects = "SELECT * FROM tbl_subjects";
}



$results_per_page = 10;
if (isset($_GET['pageno'])) {
    $pageno = (int)$_GET['pageno'];
    $page_first_result = ($pageno - 1) * $results_per_page;
} else {
    $pageno = 1;
    $page_first_result = 0;
}

$stmt = $conn->prepare($sqlsubjects);
$stmt->execute();
$number_of_result = $stmt->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page);
$sqlsubjects = $sqlsubjects . " LIMIT $page_first_result , $results_per_page";
$stmt = $conn->prepare($sqlsubjects);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();


function truncate($string, $length, $dots = "...") {
    return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="../css/stylepage.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../js/menu.js" defer></script>

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
        <div class="w3-container w3-center">
            <h3 class="w3-cursive">Welcome to MyTutor</h3>
        </div>
    </div>
    <div class="w3-card w3-container w3-padding w3-margin w3-round">
        <h3 class="w3-cursive"><b>Subject Search</b></h3>
        <form>
            <div class="w3-row">
                <div class="w3-half" style="padding-right:4px">
                    <p><input class="w3-input w3-block w3-round w3-border" type="search" name="search" placeholder="Enter search term" /></p>
                </div>
            </div>
            <button class="w3-button w3-pink w3-round w3-right" type="submit" name="submit" value="search">search</button>
        </form>
    </div>

    <div class="w3-grid-template">
        <?php
        $i = 0;
        foreach ($rows as $subject){
            $i++;
            $subid = $subject['subject_id'];
            $subname = truncate($subject['subject_name'],20);
            $subdesc = $subject['subject_description'];
            $subprice = number_format((float)$subject['subject_price'], 2, '.', '');
            $subsession = $subject['subject_sessions'];
            $subrate=  number_format((float)$subject['subject_rating'], 2, '.', '');
            echo "<div class='w3-card-4' style='margin:4px'>
            <header class='w3-container w3-green w3-center' style='text-shadow:1px 1px 0 #444'><h5><b>$subname</b></h5></header>";
            echo "<a href='subjectdetails.php?subid=$subid' style='text-decoration: none;'> <img class='w3-image' src=../../../assets/courses/$subid.jpg" .
            " onerror=this.onerror=null;"
            . " style='width:100%;height:250px'></a><hr>";
            echo "<div class='w3-container w3-cursive'><p><b>Subject Description:</b> $subdesc<br><b>Price:</b> RM $subprice<br><b>Subject Session:</b> $subsession<br><b>Subject Rating:</b> $subrate<br><div class='w3-button w3-pink w3-border w3-border-pink w3-hover-white w3-round-xlarge ' style='width:100% ' onClick='addCart($subid)'><b>Subscribe</b></div></p></div>
            </div>";
        }
        ?>
    </div>
    <br>
    <?php
    $num = 1;
    if ($pageno == 1) {
        $num = 1;
    } else if ($pageno == 2) {
        $num = ($num) + 10;
    } else {
        $num = $pageno * 10 - 9;
    }
    echo "<div class='w3-container w3-row'>";
    echo "<center>";
    for ($page = 1; $page <= $number_of_page; $page++) {
        echo '<a href = "main_screen.php?pageno=' . $page . '" style=
            "text-decoration: none">&nbsp&nbsp' . $page . ' </a>';
    }
    echo " ( " . $pageno . " )";
    echo "</center>";
    echo "</div>";
    ?>
    <br>
    <footer class="w3-footer w3-center w3-bottom w3-pink w3-cursive">MyTutor</footer>

</body>

</html>