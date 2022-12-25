<?php
session_start();
include_once 'connect-db.php';

if (isset($_POST['btnLogin'])) {
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $password = mysqli_real_escape_string($link, md5($_POST['password']));

    $sql = "SELECT *FROM user WHERE username='$username' AND password='$password'";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        header("location: index.php");
    } else {
        $message = '<script> swal("ຜິດພາດ", "ບັນຊີເຂົ້າໃຊ້ ແລະ ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ!",
         "error", {button: "ຕົກລົງ"});</script>';
    }
}
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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/sweetalert.min.js"></script>

    <style>
    body,
    html {
        height: 90%;
    }
    </style>

</head>

<body>
    <?php
    include_once 'menu.php';
    echo @$message;
    ?>

    <div class="container h-100">
        <div class="row align-items-center h-100">
            <div class="col-md-6 mx-auto">
                <div class="card border-info">
                    <div class="card-header bg-info text-white">
                        <h5>ເຂົ້າໃຊ້ລະບົບ</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="mb-3 mt-3">
                                <label for="username" class="form-label">ບັນຊີເຂົ້າໃຊ້:</label>
                                <input type="username" class="form-control" id="username"
                                    placeholder="ປ້ອນບັນຊີເຂົ້າໃຊ້" name="username" required value="<?= @$username ?>">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">ລະຫັດຜ່ານ:</label>
                                <input type="password" class="form-control" id="password" placeholder="ປ້ອນລະຫັດຜ່ານ"
                                    name="password" required>
                            </div>
                            <div class="form-password-toggle">
                                <label class="form-label" for="multicol-password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="multicol-password" class="form-control"
                                        placeholder="············" aria-describedby="multicol-password2">
                                    <span class="input-group-text cursor-pointer" id="multicol-password2"><i
                                            class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="d-grid">
                                <input type="submit" class="btn btn-primary btn-block" name="btnLogin"
                                    value="ເຂົ້າໃຊ້ລະບົບ">
                            </div>
                            <br>
                        </form>
                    </div>
                </div>
            </div>
            <!--ສິນສຸດໜ້າເຂົ້າໃຊ້ລະບົບ-->
        </div>
    </div>

</body>

</html>