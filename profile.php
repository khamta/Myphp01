<?php
 include_once 'login-check.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ລະບົບຈັດການຂໍ້ມູນພະນັກງານ</title>
    <link rel="icon" href="images/icon_logo.jpg">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="myCSS/myStyle.css">
    <script src="js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php include_once 'menu.php' ?>

    <div class="container-fluid mt-3">
    <?php    
    echo "ສະບາຍດີ ". $_SESSION['username'];
    ?>
    
    </div>
</body>

</html>