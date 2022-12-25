<?php
include_once 'connect-db.php';
$grade = $_POST['grade'];
$sql = "DELETE FROM salary WHERE grade='$grade'";
mysqli_query($link, $sql);