<?php
include_once 'login-check.php';
include_once 'function/function.php';

$dno = $dept_name = $location = $incentive = $message = "";
if (isset($_POST['btnAdd'])) {
    $dno = data_input($_POST['dno']);
    $dept_name = data_input($_POST['dept_name']);
    $location = data_input($_POST['location']);
    $incentive = str_replace(",", "", data_input($_POST['incentive']));

    //ກວດລະຫັດຊໍ້ໍາ
    $sql = "SELECT dno FROM dept WHERE dno='$dno'";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) == true) {
        $error_dno = "ລະຫັດນີ້ຖືກນໍາໃຊ້ແລ້ວ!";
    } else {
        $sql = "INSERT INTO dept VALUES('$dno', '$dept_name', '$location', '$incentive')";
        $result = mysqli_query($link, $sql);
        if ($result == true) {
            $dno = $dept_name = $location = $incentive = $message = "";
            $message = '<script> swal("ສໍາເລັດ", "ເພີ້ມຂໍ້ມູນລົງໃນຖານຂໍ້ມູນສໍາເລັດ",
                    "success", {button: "ຕົກລົງ"}); </script>';
        } else {
            echo mysqli_error($link);
        }
    }
} else if (@$_GET['action'] == 'edit') {
    $dno = $_GET['dno'];
    $sql = "SELECT *FROM dept WHERE dno = '$dno'";

    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $dno = $row['dno'];
        $dept_name =  $row['name'];
        $location =  $row['loc'];
        $incentive =  $row['incentive'];
    }
} else if (isset($_POST['btnEdit'])) {
    $dno = data_input($_POST['dno']);
    $dept_name = data_input($_POST['dept_name']);
    $location = data_input($_POST['location']);
    $incentive = str_replace(",", "", data_input($_POST['incentive']));

    $sql = "UPDATE dept SET name='$dept_name', loc='$location', incentive='$incentive' WHERE dno='$dno'";
    $result = mysqli_query($link, $sql);
    if ($result == true) {
        $dno = $dept_name = $location = $incentive = $message = "";
        $message = '<script> swal("ສໍາເລັດ", "ປັບປຸງຂໍ້ມູນໃນຖານຂໍ້ມູນສໍາເລັດ",
            "success", {button: "ຕົກລົງ"});</script>';
    } else {
        echo mysqli_error($link);
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
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css">

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap5.min.js"></script>
    <script src="js/jquery.priceformat.min.js"></script>

</head>

<body>
    <?php include_once 'menu.php'; ?>
    <?= @$message ?>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-4">
                <fieldset class="border border-primary p-2 px-4 pb-4 rounded-3">
                    <legend class="float-none w-auto p-2 h6 fw-bold">ຈັດການຂໍ້ມູນພະແນກ</legend>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="mb-3">
                            <label for="dno" class="form-label">ລະຫັດພະແນກ:</label>
                            <input type="text" class="form-control" id="dno" placeholder="ປ້ອນລະຫັດພະແນກ" name="dno" required value="<?= @$dno ?>" <?php if (@$_GET['action'] == 'edit') echo 'readonly' ?>>
                            <div class="form-control-feedback">
                                <div class="text-danger">
                                    <?= @$error_dno ?>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="dept_name" class="form-label">ຊື່ພະແນກ:</label>
                            <input type="text" class="form-control" id="dept_name" placeholder="ປ້ອນຊື່ພະແນກ" name="dept_name" required value="<?= @$dept_name ?>">
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">ສະຖານທີ່:</label>
                            <input type="text" class="form-control" id="location" placeholder="ປ້ອນສະຖານທີ່" name="location" required value="<?= @$location ?>">
                        </div>
                        <div class="mb-3">
                            <label for="incentive" class="form-label">ເງິນອຸດໜູນ:</label>
                            <input type="text" class="form-control" id="incentive" placeholder="ປ້ອນປັນຊເງິນອຸດໜູນ" name="incentive" required value="<?= @$incentive ?>">
                        </div>
                        <?php
                        if (@$_GET['action'] == 'edit') {

                            echo '<button type="submit" name="btnEdit" class="btn btn-info" style="width: 110px; border-radius: 8px;"><i class="fas fa-plus-circle"></i>&nbsp;ແກ້ໄຂ</button>';
                        } else {
                            echo '<button type="submit" name="btnAdd" class="btn btn-primary" style="width: 110px; border-radius: 8px;"><i class="fas fa-plus-circle"></i>&nbsp;ເພີ້ມ</button>';
                        }
                        ?>

                        <button type="submit" name="reset" class="btn btn-warning" style="width: 110px; border-radius: 8px;"><i class="fas fa-sync"></i>&nbsp;ຍົກເລີກ</button>
                    </form>
                </fieldset>
            </div>
            <!-- ສະແດງຂໍ້ມູນພະແນກ -->
            <div class="col-md-8 mt-3">
                <table id="example" class="table table-hover table-bordered" style="width:100%;">
                    <thead class="bg-secondary text-center text-white">
                        <tr>
                            <th>ລະຫັດ</th>
                            <th>ພະແນກ</th>
                            <th>ສະຖານທີ່</th>
                            <th>ເງິນອຸດໜູນ</th>
                            <th>ອ໋ອບຊັນ</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $sql = "SELECT *FROM dept";
                        $result = mysqli_query($link, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td class="text-center"><?= $row['dno'] ?></td>
                                <td><?= $row['name'] ?></td>
                                <td><?= $row['loc'] ?></td>
                                <td class="text-end"><?= number_format($row['incentive']) ?></td>

                                <td class="text-center" style="width: 80px;">
                                    <a href="department.php?action=edit&dno=<?= $row['dno'] ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="ແກ້ໄຂ"><i class="fas fa-edit text-success"></i></a>
                                    <a href="#" onclick="deletedata(<?php echo '\'' . $row['dno'] . '\''; ?>)" data-bs-toggle="tooltip" data-bs-placement="left" title="ລືບຂໍ້ມູນ"><i class="fas fa-trash-alt text-danger"></i></a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>

<script>
    $(document).ready(function() {
        $('#example').DataTable();

        /*ແຍກຈຸດຫຼັກພັນ ....*/
        $('#incentive').priceFormat({
            prefix: '',
            thounsandsSeparator: ',',
            centsLimit: 0
        });
    });

    //Tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    //ສ້າງຟັງຊັນແຈ້ງເຕືອນລືບຂໍ້ມູນ
    function deletedata(id) {
        swal({
                title: "ເຈົ້າຕ້ອງການລືບແທ້ ຫຼື ບໍ່?",
                text: "ຂໍ້ມູນລະຫັດ " + id + ", ເມື່ອລືບຈະບໍ່ສາມາດກູ້ຂໍ້ມູນຄືນໄດ້!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                buttons: ['ຍົກເລີກ', 'ຕົກລົງ']
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "dept-delete.php",
                        method: "post",
                        data: {
                            dno: id
                        },
                        success: function(data) {
                            if (data) {
                                //alert(data); //ເພື່ອກວດສອບຂໍ້ຜິດພາດເວລາທົດສອບ
                                swal("ຜິດພາດ", "ບໍ່ສາມາດລືບຂໍ້ມູນນີ້ໄດ້ ເນື່ອງຈາກມີພະນັກງານສັງກັດໃນພະແນກນີ້ຢູ່!", "error", {
                                    button: "ຕົກລົງ",
                                });
                            } else {
                                swal("ສໍາເລັດ", "ຂໍ້ມູນຖືກລືບອອກຈາກຖານຂໍ້ມູນແລ້ວ", "success", {
                                    button: "ຕົກລົງ",
                                });
                                setTimeout(function() {
                                    location.reload();
                                }, 2000); //2000 = 2ວິນາທີ
                            }
                        }
                    });

                } else {
                    swal("ຂໍ້ມູນຂອງທ່ານຍັງປອດໄພ!", {
                        button: "ຕົກລົງ",
                    });
                }
            });
    }

    /* ບໍ່ໃຫ້ມັນຊັບມິດຄືນ*/
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>