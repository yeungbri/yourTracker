<?php
   include('config.php');
   session_start();
   
   $user_check = $_SESSION['user_id'];
   $ses_sql = mysqli_query($db, "SELECT user_id, email FROM user WHERE email = '$user_check'");
   $row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);
   $login_session = $row['user_id'];
   $login_email = $row['email'];
   $clicked = $_SESSION['qr'];
   
   if(!isset($_SESSION['user_id'])){
      header("location:login.php");
   }
?>