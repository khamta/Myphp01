<?php
include_once 'connect-db.php';
$dno = $_POST['dno'];
$sql = "DELETE FROM dept WHERE dno='$dno'";
mysqli_query($link, $sql);