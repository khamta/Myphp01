<?php
session_start();
include_once 'connect-db.php';
if(isset($_SESSION['username']) && isset($_SESSION['password'])) {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $sql = "SELECT *FROM user WHERE username='$username' AND password='$password'";
    $result = mysqli_query($link, $sql);
    if(mysqli_num_rows($result) < 0) {
        header("location: login-form.php");
    } 
} else {
    header("location: login-form.php");
}