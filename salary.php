<?php
include_once 'login-check.php';
include_once 'function/function.php';

$grade = $salary = "";
if (isset($_POST['btnAdd'])) {
    $grade = data_input($_POST['grade']);
    $salary = str_replace(",", "", data_input($_POST['salary']));

    //ກວດລະຫັດຊໍ້ໍາ
    $sql = "SELECT salary FROM salary WHERE grade='$grade'";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) == true) {
        $error_grade = "ລະຫັດນີ້ຖືກນໍາໃຊ້ແລ້ວ!";
    } else {
        $sql = "INSERT INTO salary VALUES('$grade','$salary')";
        $result = mysqli_query($link, $sql);
        if ($result == true) {
            $grade = $salary = "";
            $message = '<script> swal("ສໍາເລັດ", "ເພີ້ມຂໍ້ມູນລົງໃນຖານຂໍ້ມູນສໍາເລັດ",
                            "success", {button: "ຕົກລົງ"}); 
                        </script>';
        } else {
            echo mysqli_error($link);
        }
    }
} else if (@$_GET['action'] == 'edit') {
    $grade = $_GET['grade'];
    $sql = "SELECT *FROM salary WHERE grade = '$grade'";

    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $grade = $row['grade'];
        $salary =  $row['salary'];
    }
} else if (isset($_POST['btnEdit'])) {

    $grade = data_input($_POST['grade']);
    $salary = str_replace(",", "", data_input($_POST['salary']));

    $sql = "UPDATE salary SET salary='$salary' WHERE grade='$grade'";
    $result = mysqli_query($link, $sql);
    if ($result == true) {
        $grade = $salary = "";
        $message = '<script> swal("ສໍາເລັດ", "ປັບປຸງຂໍ້ມູນໃນຖານຂໍ້ມູນສໍາເລັດ",
                        "success", {button: "ຕົກລົງ"});
                    </script>';
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
    <?php include_once 'menu.php' ?>
    <?= @$message ?>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-4">
                <fieldset class="border border-primary p-2 px-4 pb-4 rounded-3">
                    <legend class="float-none w-auto p-2 h6 fw-bold">ຈັດການຂໍ້ມູນຂັ້ນເງິນເດືອນ</legend>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="mb-3">
                            <label for="grade" class="form-label">ຂັ້ນເງິນເດືອນ:</label>
                            <input type="text" class="form-control" id="grade" placeholder="ປ້ອນຂັ້້ນເງິນເດືອນ" name="grade" required value="<?= @$grade ?>" <?php if (@$_GET['action'] == 'edit') echo 'readonly' ?>>
                            <div class="form-control-feedback">
                                <div class="text-danger">
                                    <?= @$error_grade ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="salary" class="form-label">ເງິນເດືອນ:</label>
                            <input type="text" class="form-control" id="salary" placeholder="ປ້ອນເງິນເດືອນ" name="salary" required value="<?= @$salary ?>">
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
                            <th>ເງິນເດືອນ</th>
                            <th>ອ໋ອບຊັນ</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $sql = "SELECT *FROM salary";
                        $result = mysqli_query($link, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td class="text-center"><?= $row['grade'] ?></td>
                                <td class="text-end"><?= number_format($row['salary']) ?></td>

                                <td class="text-center" style="width: 80px;">
                                    <a href="salary.php?action=edit&grade=<?= $row['grade'] ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="ແກ້ໄຂ"><i class="fas fa-edit text-success"></i></a>
                                    <a href="#" onclick="deletedata(<?php echo '\'' . $row['grade'] . '\''; ?>)" data-bs-toggle="tooltip" data-bs-placement="left" title="ລືບຂໍ້ມູນ"><i class="fas fa-trash-alt text-danger"></i></a>
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
        $('#salary').priceFormat({
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
                        url: "salary-delete.php",
                        method: "post",
                        data: {
                            grade: id
                        },
                        success: function(data) {
                            if (data) {
                                alert(data);
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