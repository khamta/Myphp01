<?php

include_once 'connect-db.php';
$empno = $_POST['empno'];
//ລືບຮູບ
$sql = "SELECT picture FROM emp WHERE empno='$empno'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($result);
//ລຶບຮູບດ້ວຍ unlink
$picture = is_numeric($row['picture']) ? "avatar_img.png" : $row['picture'];
if ($picture != "avatar_img.png") { //ປັບປຸງໂຄ້ດໂປຣແກຣມຕ່າງຈາກວິດີໂອເນື່ອງຈາກມີ bug
    unlink("images/$picture");
}

//ລືບຂໍ້ມູນ
$sql = "DELETE FROM emp WHERE empno='$empno' ";
mysqli_query($link, $sql);

