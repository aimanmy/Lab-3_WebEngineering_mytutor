<?php
session_start();
include_once("dbconnect.php");
if (isset($_SESSION['sessionid'])) {
    $user_email = $_SESSION['email'];
    $user_name = $_SESSION['name'];
    $user_phone = $_SESSION['phone'];
    $sqltutors = "SELECT * FROM tbl_tutors";
   
}

$results_per_page = 10;
if (isset($_GET['pageno'])) {
    $pageno = (int)$_GET['pageno'];
    $page_first_result = ($pageno - 1) * $results_per_page;
} else {
    $pageno = 1;
    $page_first_result = 0;
}

$stmt = $conn->prepare($sqltutors);
$stmt->execute();
$number_of_result = $stmt->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page);
$sqltutors = $sqltutors . " LIMIT $page_first_result , $results_per_page";
$stmt = $conn->prepare($sqltutors);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();
$conn= null;

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
        <div class="w3-container w3-center">
            <h3 class="w3-cursive">Tutor Profile</h3>
        </div>
    </div>

    <div class="w3-grid-template">
        <?php
        $i = 0;
        foreach ($rows as $tutor){
            $i++;
            $tutorid = $tutor['tutor_id'];
            $tutorname = truncate($tutor['tutor_name'],20);
            $tutoremail = $tutor['tutor_email'];
            $tutorphone = $tutor['tutor_phone'];
            $tutordesc = $tutor['tutor_description'];
            echo "<div class='w3-card-4 w3-round' style='margin:4px'>
            <header class='w3-container w3-green w3-center'style='text-shadow:1px 1px 0 #444'><h5><b>$tutorname</b></h5></header>";
            echo "<a href='productdetails.php?prid=$tutorid' style='text-decoration: none;'> <img class='w3-image' src=../../../assets/tutors/$tutorid.jpg" .
                " onerror=this.onerror=null;this.src='../../admin/res/newproduct.jpg'"
                . " style='width:100%;height:250px'></a><hr>";
            echo "<div class='w3-container w3-cursive'><p><b>Tutor Email:</b> $tutoremail<br><b>Tutor Phone Number:</b> $tutorphone<br><b>Tutor Description:</b> $tutordesc<br></p></div>
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
        echo '<a href = "tutorpage.php?pageno=' . $page . '" style=
            "text-decoration: none">&nbsp&nbsp' . $page . ' </a>';
    }
    echo " ( " . $pageno . " )";
    echo "</center>";
    echo "</div>";
    ?>
    <br>
    <footer class="w3-footer w3-center w3-bottom w3-pink cursive">Mytutor</footer>

</body>

</html>