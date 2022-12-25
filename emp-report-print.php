<?php
include_once 'login-check.php';
include_once 'laokip-read.php';

$department = "";
$where = "";
if (isset($_GET['department'])) {
    $department = $_GET['department'];
    $where = empty($department) ? " " : " WHERE d.dno = '$department' ";
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
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <style>
        table {
            border-collapse: collapse;
        }

        td,
        th {
            border: 1px black solid;
            height: 35px;
        }
    </style>
</head>

<body>
    <div class="container-fluid mt-3">
        <div class="text-center">
            <img src="images/laos-national.jpg" width="200px" alt="ຮູບກາຊາດ"> <br>
            ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ<br>
            ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັດທະນະຖາວອນ<br>
            <p>-----------<?php for ($i = 0; $i < 6; $i++) echo '<i class="far fa-star"></i>'; ?>-----------</p>
        </div>
        <div class="row">
            <div class="col-6">
                ຊື່ບໍລິສັດ.............<br>
                ທີ່ຢູ່.............<br>
                ເບີໂທ.............<br>
            </div>
            <div class="col-6 text-end">
                ເລກທີ............/.........<br>
                ທີ່ ນະຄອນຫຼວງວຽງຈັນ, ວັນທີ.....................<br>
            </div>
            <p class="text-center fw-bold h5">ລາຍງານຂໍ້ມູນພະນັກງານ</p>
        </div>
        <table class="w-100">
            <thead class="bg-dark text-white text-center">
                <tr>
                    <th>ລະຫັດ</th>
                    <th>ຊື່ ແລະ ນາມສະກຸນ</th>
                    <th>ເພດ</th>
                    <th>ເງິນເດືອນ</th>
                    <th>ເງິນອຸດໜູນ</th>
                    <th>ລາຍຮັບລວມ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $department = "";
                $sum = 0;
                $sql = "SELECT e.empno, e.name, e.gender, d.name AS department, s.salary, e.incentive, s.salary+e.incentive AS total "
                    . " FROM emp e JOIN dept d ON e.dno = d.dno JOIN salary s ON e.grade = s.grade $where ORDER BY department ASC, total DESC";
                $result = mysqli_query($link, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    //ສະແດງຊື່ຂອງພະແນກ ແລະ ຜົນບວກທັງໝົດເງິນເດືອນ ບວກ ເງິນອຸດອຸດໝູນ ຂອງພະແນກນັ້້ນ
                    if (strcmp($department, $row['department']) !== 0) {
                        $department = $row['department'];
                        $sql1 = "SELECT sum(s.salary+e.incentive) FROM emp e JOIN dept d ON e.dno=d.dno JOIN salary s ON e.grade=s.grade "
                            . " WHERE d.name='$department'";
                        $result1 = mysqli_query($link, $sql1);
                        $row1 = mysqli_fetch_array($result1);
                ?>
                        <tr>
                            <td colspan="5" class="fw-bold text-primary" style="background: #D9D9D9;"><?php echo "$department: " . LakLao($row1[0]) ?></td>
                            <td class="fw-bold text-primary text-end" style="background: #D9D9D9;"><?= number_format($row1[0]) ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td class="text-center"><?= $row['empno'] ?></td>
                        <td><?= $row['name'] ?></td>
                        <td class="text-center"><?= $row['gender'] ?></td>
                        <td class="text-end"><?= number_format($row['salary']) ?></td>
                        <td class="text-end"><?= number_format($row['incentive']) ?></td>
                        <td class="text-end"><?= number_format($row['total']) ?></td>
                    </tr>
                <?php
                    $sum += $row['total'];
                }
                ?>
                <tr>
                    <td colspan="5" class="fw-bold text-danger" style="background: #D9D9D9;">ລວມທັງໝົດ: <?= LakLao($sum) ?></td>
                    <td class="fw-bold text-danger text-end" style="background: #D9D9D9;"><?= number_format($sum) ?></td>
                </tr>
            </tbody>
        </table>
        <br>
        <table class="border-0 w-100">
            <tr>
                <td class="text-center fw-bold border-0">ລາຍເຊັນ3</td>
                <td  class="text-center fw-bold border-0">ລາຍເຊັນ2</td>
                <td  class="text-center fw-bold border-0">ລາຍເຊັນ1</td>
            </tr>
        </table>
    </div>
</body>

</html>
<script>
    $(document).ready(function() {
        window.onafterprint = window.close;
        window.print();
    });
</script>