<?php
include_once 'login-check.php';
include_once 'function/function.php';
//ຮັບຄ່າຈາກຟອມຖ້າມີການກົດປຸ່ມຊື່ btnAdd
if (isset($_POST['btnAdd'])) {
    $empno = data_input($_POST['empno']);
    $empname = data_input($_POST['empname']);
    $gender = $_POST['gender'];
    $date_birth = $_POST['date_birth'];
    $address = nl2br(trim(stripslashes($_POST['address']))); //ຖ້າລົງແຖວໃຫ້ມັນໃສ່ tag <br />
    //ຮັບຂໍ້ມູນປະເພດໄຟລ໌
    $file_image = $_FILES['file_image']['name'];
    $file_tmp = $_FILES['file_image']['tmp_name'];

    $department = $_POST['department'];
    $salary = $_POST['salary'];
    $incentive = str_replace(",", "", $_POST['incentive']); //ຮັບຄ່າມາແລ້ວຕັດເຄື່ອງໝາຍຈຸດອອກ
    $language = implode(",", $_POST['language']); //ລວມອາເຣໃຫ້ເປັນຂໍ້ຄວາມຂັ້ນກັນດ້ວຍເຄື່ອງໝາຍຈຸດ
    //ທົດສອບຄ່າທີ່ຮັບມາຈາກຟອມ
    //    echo "1.$empno<br>2.$empname<br>3.$gender<br>4.$date_birth<br>5.$address<br>6.$file_image<br>"
    //    . "7.$department<br>8.$salary<br>9.$incentive<br>10.$language";
    //ກວດສອບລະຫັດ
    $sql = "SELECT empno FROM emp WHERE empno = '$empno' ";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) > 0) {
        $message = '<script> swal("ຜິດພາດ", "ລະຫັດພະນັກງານນີ້ຖືກນໍາໃຊ້ແລ້ວ", "error",{button: "ຕົກລົງ",}); </script>';
    } else {
        $file_image = round(round(microtime(TRUE))) . $file_image;
        move_uploaded_file($file_tmp, "images/" . $file_image);

        $sql = "INSERT INTO emp VALUES('$empno', '$empname', '$gender', '$date_birth', '$address', "
            . "  '$incentive',  '$language', '$file_image', '$salary', '$department')";
        $result = mysqli_query($link, $sql);
        if ($result) {
            $message = '<script> swal("ສໍາເລັດ","ຂໍ້ມູນບັນທຶກລົງຖານຂໍ້ມູນແລ້ວ","success",{button: "ຕົກລົງ",}); </script>';
            $empno = $empname = $gender = $date_birth = $address = $file_image = $department = $salary = $incentive = $language = "";
        } else {
            echo mysqli_error($link);
        }
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
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <link rel="stylesheet" href="myCSS/myStyle.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <!--ໃຊ້ໃນສໍາລັບເລືອກຮູບໃຫ້ສະແດງພ້ອມ -->
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.priceformat.min.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <style>
        .btn-file {
            position: relative;
            overflow: hidden;
        }

        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }

        #img-upload {
            width: 150px;
            height: 185px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <?php include_once 'menu.php' ?>
    <?= @$message ?>
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <span class="d-flex justify-content-end">
                    <a href="emp-manage.php" class="btn btn-secondary"><i class="fas fa-address-card"></i>&nbsp;ສະແດງຂໍ້ມູນ</a>
                </span>
                <div class="card border-primary">
                    <div class="card-header bg-info text-white h5">ຟອມປ້ອນຂໍ້ມູນພະນັກງານ</div>
                    <div class="card-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <!-- 1, ລະຫັດພະນັກງານ -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="empno" class="form-label">ລະຫັດພະນັກງານ:</label>
                                                <input type="text" class="form-control" id="empno" placeholder="ກະລຸນາປ້ອນລະຫັດພະນັກງານ" name="empno" value="<?= @$empno ?>" required>
                                            </div>
                                        </div>
                                        <!-- 2, ຊື່ພະນັກງານ -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="empname" class="form-label">ຊື່ນັກງານ:</label>
                                                <input type="text" class="form-control" id="empname" placeholder="ກະລຸນາປ້ອນຊື່ພະນັກງານ" name="empname" value="<?= @$empname ?>" required>
                                            </div>
                                        </div>
                                        <!-- 3, ເພດ -->
                                        <div class="col-md-6">
                                            <fieldset class="mb-3">
                                                <p>ເພດ</p>
                                                <div class="form-check-inline">
                                                    <input type="radio" class="form-check-input" id="gender1" name="gender" value="ຊ" <?php if (@$gender == "" || @$gender == "ຊ") echo 'checked'; ?>>
                                                    <label class="form-check-label" for="gender1">ຊາຍ</label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <input type="radio" class="form-check-input" id="gender2" name="gender" value="ຍ" <?php if (@$gender == "ຍ") echo 'checked'; ?>>
                                                    <label class="form-check-label" for="gender2">ຍິງ</label>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <!--ວັນເດືອນປີເກີດ-->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="date_birth" class="form-label">ວັນ, ເດືອນ ປີເກີດ:</label>
                                                <input type="date" class="form-control" id="date_birth" name="date_birth" value="<?= @$date_birth ?>" required>
                                            </div>
                                        </div>
                                        <!--ທີ່ຢູ່-->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="address">ທີ່ຢູ່:</label>
                                                <textarea class="form-control" rows="5" id="address" name="address"><?=strip_tags(@$address) ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="row">
                                        <!--ໃສຮູບພາບ-->
                                        <div class="col-md-12">
                                            <div style="text-align: center">
                                                <img id='img-upload' />
                                                <div id="temp_img">
                                                    <img src="images/avatar_img.png" alt="" width="150px" height="180px" />
                                                </div>
                                                <!--ເລືອກຮູບພາບ-->
                                                <br>
                                                <div class="input-group">
                                                    <span class="input-group-btn">
                                                        <span class="btn btn-info btn-file">
                                                            ເລືອກຮູບ<input type="file" id="imgInp" name="file_image" accept="image/*">
                                                        </span>
                                                    </span>
                                                    <input type="text" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ຊື່ພະແນກ -->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="deparment" class="form-label">ພະແນກ</label>
                                                <select class="form-select" id="deparment" name="department" required="true">
                                                    <option value="">----ເລືອກພະແນກ-----</option>
                                                    <?php
                                                    $sql = "SELECT dno, name FROM dept";
                                                    $result = mysqli_query($link, $sql);
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                    ?>
                                                        <option value="<?= $row['dno'] ?>" <?php if (@$department == $row['dno']) echo 'selected'; ?>><?= $row['name'] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- ຂັ້ນເງິນເດືອນ -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="salary" class="form-label">ຂັ້ນເງິນເດືອນ</label>
                                        <select class="form-select" id="salary" name="salary" required="true">
                                            <option value="">----ເລືອກຂັ້ນເງິນເດືອນ-----</option>
                                            <?php
                                            $sql = "SELECT *FROM salary";
                                            $result = mysqli_query($link, $sql);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                                <option value="<?= $row['grade'] ?>" <?php if (@$salary == $row['grade']) echo 'selected'; ?>><?php echo $row['grade'] . " = " . number_format($row['salary']); ?></option>
                                            <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>
                                <!--  ເງິນອຸດໜູນ -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="incentive" class="form-label">ເງິນອຸດໜູນ</label>
                                        <input type="text" class="form-control" id="incentive" placeholder="ປ້ອນເງິນອຸດໜູນ" name="incentive" value="<?= @$incentive ?>" min="0">
                                    </div>
                                </div>
                                <!--ພາສາຕ່າງປະເທດ -->
                                <div class="col-md-4">
                                    <fieldset class="form-group">
                                        <p>ພາສາຕ່າງປະເທດ</p>
                                        <div class="form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="language[]" value="ອັງກິດ" <?php if (strpos(@$language, "ອັງກິດ") !== FALSE) echo 'checked'; ?>>
                                            <label class="form-check-label">ອັງກິດ</label>
                                        </div>
                                        <div class="form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="language[]" value="ຈີນ" <?php if (strpos(@$language, "ຈີນ") !== FALSE) echo 'checked'; ?>>
                                            <label class="form-check-label">ຈີນ</label>
                                        </div>
                                        <div class="form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="language[]" value="ຫວຽດນາມ" <?php if (@strpos($language, "ຫວຽດນາມ") !== FALSE) echo 'checked'; ?>>
                                            <label class="form-check-label">ຫວຽດນາມ</label>
                                        </div>
                                        <div class="form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="language[]" value="ຝຣັ່ງ" <?php if (strpos(@$language, "ຝຣັ່ງ") !== FALSE) echo 'checked'; ?>>
                                            <label class="form-check-label">ຝຣັ່ງ</label>
                                        </div>
                                        <div class="form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="language[]" value="ອື່ນໆ..." <?php if (strpos(@$language, "ອື່ນໆ...") !== FALSE) echo 'checked'; ?>>
                                            <label class="form-check-label">ອື່ນໆ...</label>
                                        </div>
                                    </fieldset>
                                </div>
                                <!--ປຸ່ມຕ່າງ-->
                                <div class="col-md-12 text-center">
                                    <input type="submit" id="btnAdd" name="btnAdd" value="ເພີ້ມຂໍ້ມູນ" class="btn btn-primary" style="width: 100px; border-radius: 20px">
                                    &nbsp;&nbsp;
                                    <input type="reset" value="ຍົກເລີກ" class="btn btn-warning" style="width: 100px; border-radius: 20px">
                                    &nbsp;&nbsp;
                                    <button onclick="window.location.reload(true)" class="btn btn-success" style="width: 100px; border-radius: 20px;">ໂຫຼດຄືນໃໝ່</button>
                                    <p></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>
<script>
    $(document).ready(function() {
        /*ເລືອກຮູບພາບ*/
        $('#img-upload').hide();
        $(document).on('change', '.btn-file :file', function() {
            var input = $(this),
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [label]);
            $('#temp_img').hide(); /*ໃຫ້ເຊືອງເມືອເລືອກຮູບ*/
            $('#img-upload').show();
        });

        $('.btn-file :file').on('fileselect', function(event, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = label;

            if (input.length) {
                input.val(log);
            } else {
                if (log)
                    alert(log);
            }

        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#img-upload').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function() {
            readURL(this);
        });
        /*ສິ້ນສຸດເລືອກຮູບ*/


        /*ແຍກຈຸດຫຼັກພັນ ....*/
        $('#incentive').priceFormat({
            prefix: '',
            thounsandsSeparator: ',',
            centsLimit: 0
        });

    });

    /* ບໍ່ໃຫ້ມັນຊັບມິດຄືນ*/
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>