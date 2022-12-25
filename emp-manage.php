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
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css">

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap5.min.js"></script>
    <!--ໃຊ້ໃນສໍາລັບເລືອກຮູບໃຫ້ສະແດງພ້ອມ-->


</head>

<body>
    <?php include('menu.php') ?>
    <div class="container-fluid" style="margin-top: 10px;">

        <div class="alert alert-success alert-dismissible text-center">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>ຈັດການຂໍ້ມູນພະນັກງານ</strong>
        </div>

        <p class="d-flex justify-content-end">
            <a href="emp-add.php" class=" btn btn-success text-white"><i class="fas fa-plus-circle"></i> ເພີ້ມຂໍ້ມູນ</a>
        </p>

        <table id="example" class="table table-hover table-bordered" style="width:100%">
            <thead class="bg-dark text-center text-white">
                <tr>
                    <th>ລະຫັດ</th>
                    <th>ຊື່ ແລະ ນາມສະກຸນ</th>
                    <th>ເພດ</th>
                    <th>ພະແນກ</th>
                    <th>ອ໋ອບຊັນ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT e.empno, e.name, e.gender, d.name AS department FROM  emp e JOIN dept d ON e.dno = d.dno";
                $result = mysqli_query($link, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td style="text-align: center"><?= $row['empno'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td style="text-align: center"><?= $row['gender'] ?></td>
                        <td><?= $row['department'] ?></td>
                        <td style="width: 80px; text-align: center">
                            <a href="#" onclick="viewdata(<?php echo '\'' . $row['empno'] . '\''; ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="ລາຍລະອຽດ"><i class="fas fa-eye"></i></a>
                            <a href="emp-edit.php?empno=<?= $row['empno'] ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="ແກ້ໄຂ"><i class="fas fa-edit text-success"></i></a>
                            <a href="#" onclick="deletedata(<?php echo '\'' . $row['empno'] . '\''; ?>)" data-bs-toggle="tooltip" data-bs-placement="left" title="ລືບຂໍ້ມູນ"><i class="fas fa-trash-alt text-danger"></i></a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- The Modal ສະແດງລາຍລະອຽດຂໍ້ມູນ -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title h5">ລາຍລະອຽດຂໍ້ມູນພະນັກງານ</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body" id="employee_detail">

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ປິດ</button>
                </div>

            </div>
        </div>
    </div>

</body>

</html>



<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });

    //Tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    /*ກົດທີ່ ສະແດງລາຍລະອຽດ */
    function viewdata(id) {
        $.ajax({
            url: "emp-view.php",
            method: "post",
            data: {
                empno: id
            },
            success: function(data) {
                $('#employee_detail').html(data);
                $('#myModal').modal("show");
            }
        });
    }
    /*ສິ້ນສຸດສະແດງລາຍລະອຽດ*/

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
                        url: "emp-delete.php",
                        method: "post",
                        data: {
                            empno: id
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
</script>