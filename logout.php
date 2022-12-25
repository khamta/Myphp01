<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['password']);
if(empty($_SESSION['username']) && empty($_SESSION['password'])) {
    header("location: login-form.php");
}