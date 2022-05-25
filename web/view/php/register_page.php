<?php
    if(isset($_POST["submit"])){
        include_once("dbconnect.php");
        $name = $_POST["name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $address = $_POST["address"];
        $password = sha1($_POST['password']);
        
        
        try{
            $sqlregister = "INSERT INTO `table_registeration`(`user_email`, `user_name`, `user_phone`, `user_address`, `user_password`) VALUES ('$email','$name','$phone','$address','$password')";
            $conn->exec($sqlregister);
            $last_id= $conn->lastInsertId();
            if(file_exists($_FILES["fileToUpload"]["tmp_name"]) || is_uploaded_file($_FILES["fileToUpload"]["tmp_name"])){
                uploadImage($last_id);
                echo "<script>alert('Registeration Successful')</script>";
                echo "<script>window.location.replace('login_page.php')</script>";
            }}catch(PDOException $e){
                echo "<script>alert('<p>Registeration Failed, This Accpunt Already Registered</p>')</script>";
                echo "<script>window.location.replace('register_page.php')</script>";
            }
    }
    
    function uploadImage($id){
        $target_dir = "../../../assets/user_image/";
        $target_file = $target_dir. $id .".png";
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    }
 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src = "../js/script.js" ></script>
    <title>Registeration</title>
</head>


<style>
        .form-container-reg{
            max-width: 100%;
            margin: auto;
        }
        .responsive{
            max-width: 100%;
            height: 100%;
            object-fit: fill;
    } 
</style>

<body>
    <div class = "w3-header w3-display-container w3-center w3-padding-32 w3-center">
        <image src="header.png" class="responsive" >
    </div>
   
    <div class="w3-container w3-margin form-container-reg">
        <div class="w3-card-4">
            <a href= "login_page.php" class="w3-btn w3-round w3-pink w3-bar-block w3-left" name="back">Back</a>
            <div class="w3-container w3-pink w3-center">
                <p>
                    Register New Account
                </p>
            </div>
            <form class = "w3-container w3-padding " name="registerForm" action="register_page.php" method="post" onsubmit="return confirmDialog()" enctype="multipart/form-data">
                <p>
                    <div class="w3-container w3-border w3-center w3-padding">
                        <img class="w3-image w3-round w3-margin" src="camera.png" style="width: 100%; max-width:600px;"><br>
                        <input type="file" name="fileToUpload" id="fileToUpload" onchange="previewFile();"><br>
                    </div>
                       
                </p>
                <p>
                    <label>Name</label>
                    <input class="w3-input w3-border w3-round " name="name" id="idname" type="text" required>
                </p>
                <p>
                    <label>Email</label>
                    <input class="w3-input w3-border w3-round" name="email" id="idemail" type="email" required>
                </p>
                <p>
                    <label>Phone Number</label>
                    <input class="w3-input w3-border w3-round" name="phone" id="idphone" type="phone" required>
                </p>
                <p>
                    <label>Address</label>
                    <textarea class="w3-input w3-border" id="idaddress" name="address" rows="4" cols="50" width="100%" placeholder="Please Enter Your Address" required></textarea>
                </p>
                <p>
                    <label>Password</label>
                    <input class="w3-input w3-border w3-round" name="password" id="idpass" type="password" required>
                </p>
                <div class="row">
                    <input class="w3-input w3-border w3-block w3-pink w3-round" type="submit" name="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>
</body>

</html>
