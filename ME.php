<?php
session_start();  
if (!isset($_SESSION['username'])) {
    header("Location: hks.php");
    exit();
}
$username = $_SESSION['username'];
include 'db_connect.php'; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Me</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>

    <div class="container">
     <img src="user_profile.jpg"  style="width: 100px; height: 100px; border-radius: 50%;  position:absolute;left: 43%; top: 5vh;">
   
        <div class="menu">
            <div class="menu-item">
                <a href="security.php">
                    <img src="Profile.jpg">
                    <span>Update your profile and details</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="change-password.php">
                    <img src="Password.jpg" >
                    <span>Change Password</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="history.php">
                    <img src="Payment.jpg" >
                    <span>Payment history</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="events.php">
                    <img src="events.jpg" >
                    <span>News and events</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="language.php">
                    <img src="language.jpg" >
                    <span>Language Settings</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="problem.php">
                    <img src="Problem.jpg" >
                    <span>Report Problem!</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="about.php">
                    <img src="About.jpg" >
                    <span>About Us</span>
                </a>
            </div>
           
        </div>
        
        <nav class="bottom-nav">
     <a href="Dashboard.php" class="nav-button" >Dashboard</a>
     <a href="FOOD.php" class="nav-button" >Food</a>
     <a href="ACCOMODATION.php">Accomodation</a>
      <a href="Me.php" class="nav-button" >Me</a>
   </nav>

   
    </div>
    </body>
</html>