<?php
include("head.php");
$arr_status=[
    "wait_confirm"=>"สั่งจองรถ",
    "confirm"=>"ยืนยันคำสั่งจอง",
    "delivery"=>"กำลังดำเนินการจัดส่ง",
    "success"=>"สำเร็จ",
    "failed"=>"ไม่สำเร็จ"
];
if(empty($_SESSION['user-id'])){echo "<script>window.location='login.php'</script>";}
$order_id=$_GET['order_id'];
$branch_id=$_GET['branch_id'];


$sqli=$conn->query("SELECT `status`,`note`,`user_id`,`date_order` FROM `tbl_order` WHERE `id`='$order_id'");
list($status,$note,$user_id,$date_order)=mysqli_fetch_row($sqli);
$sqli2=$conn->query("SELECT `name`,`surname` FROM `tbl_employee` WHERE `id`='$user_id'");
list($name,$surname)=mysqli_fetch_row($sqli2);

?>


<div class="breadcrumbs-area mb-20">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumbs-menu">
                    <ul>
                        <li><a href="#">หน้าหลัก</a></li>
                        <?php
                        if($_SESSION['user-type']=="admin")
                        {
                            ?><li><a href="branch_list.php" class="">สาขา</a></li><?php
                        }
                        ?>
                        <li><a href="order_list.php?branch_id=<?=$branch_id?>">รายการสั่งจองรถจักรยานยนต์</a></li>

                        <li><a href="#" class="active">สถานะการสั่งจอง</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="cart-main-area mb-5">
    <div class="container">

        <div class="row ">
            <div class="col-lg-12 text-center">
                <h3>ดำเนินการสั่งจองรถ</h3>
                <p>หมายเหตุ : <?=$note?></p>
            </div>
            <div class="col-lg-12 mt-3">
                <?php
            if($status=="wait_confirm")
            {
                ?>
                <div class="row">
                    <div class="col-md-3 text-center">
                        <img src="img/wait-1.png" class="mimg100" alt=""><br><br>
                        <h5>ผู้สั่งจอง : <?=$name." ".$surname?></h5>
                        <h6><?=$date_order?></h6>
                    </div>
                    <div class="col-md-3 text-center">
                        <img src="img/confirm-0.png" class="mimg100" alt=""><br><br>
                    </div>
                    <div class="col-md-3 text-center">
                        <img src="img/delivery-0.png" class="mimg100" alt=""><br><br>
                    </div>
                    <div class="col-md-3 text-center">
                        <img src="img/success-0.png" class="mimg100" alt=""><br><br>
                    </div>
                </div>
                <?php
            }else if($status=="confirm")
            {
                $sqli3=$conn->query("SELECT `user_id`,`date_accept` FROM `tbl_accept` WHERE `order_id`='$order_id' AND `status`='confirm'");
                list($user_id1,$date_accept)=mysqli_fetch_row($sqli3);
                $sqli4=$conn->query("SELECT `name`,`surname` FROM `tbl_employee` WHERE `id`='$user_id1'");
                list($name1,$surname1)=mysqli_fetch_row($sqli4);

                ?>
                <div class="row">
                    <div class="col-md-3 text-center">
                        <img src="img/wait-1.png" class="mimg100" alt=""><br><br>
                        <h5>ผู้สั่งจอง : <?=$name." ".$surname?></h5>
                        <h6><?=$date_order?></h6>
                    </div>
                    <div class="col-md-3 text-center">
                        <img src="img/confirm-1.png" class="mimg100" alt=""><br><br>
                        <h5>ผู้ยืนยัน : <?=$name1." ".$surname1?></h5>
                        <h6><?=$date_accept?></h6>
                    </div>
                    <div class="col-md-3 text-center">
                        <img src="img/delivery-0.png" class="mimg100" alt=""><br><br>
                    </div>
                    <div class="col-md-3 text-center">
                        <img src="img/success-0.png" class="mimg100" alt=""><br><br>
                    </div>
                </div>
                <?php
            }else if($status=="delivery")
            {
                $sqli3=$conn->query("SELECT `user_id`,`date_accept` FROM `tbl_accept` WHERE `order_id`='$order_id' AND `status`='confirm'");
                list($user_id1,$date_accept)=mysqli_fetch_row($sqli3);
                $sqli4=$conn->query("SELECT `name`,`surname` FROM `tbl_employee` WHERE `id`='$user_id1'");
                list($name1,$surname1)=mysqli_fetch_row($sqli4);

                ?>
                <div class="row">
                    <div class="col-md-3 text-center">
                        <img src="img/wait-1.png" class="mimg100" alt=""><br><br>
                        <h5>ผู้สั่งจอง : <?=$name." ".$surname?></h5>
                        <h6><?=$date_order?></h6>
                    </div>
                    <div class="col-md-3 text-center">
                        <img src="img/confirm-1.png" class="mimg100" alt=""><br><br>
                        <h5>ผู้ยืนยัน : <?=$name1." ".$surname1?></h5>
                        <h6><?=$date_accept?></h6>
                    </div>
                    <div class="col-md-3 text-center">
                        <img src="img/delivery-1.png" class="mimg100" alt=""><br><br>
                    </div>
                    <div class="col-md-3 text-center">
                        <img src="img/success-0.png" class="mimg100" alt=""><br><br>
                    </div>
                </div>
                <?php
            }else if($status=="success")
            {
                $sqli3=$conn->query("SELECT `user_id`,`date_accept` FROM `tbl_accept` WHERE `order_id`='$order_id' AND `status`='confirm'");
                list($user_id1,$date_accept)=mysqli_fetch_row($sqli3);
                $sqli4=$conn->query("SELECT `name`,`surname` FROM `tbl_employee` WHERE `id`='$user_id1'");
                list($name1,$surname1)=mysqli_fetch_row($sqli4);
                
                $sqli5=$conn->query("SELECT `user_id`,`date_accept` FROM `tbl_accept` WHERE `order_id`='$order_id' AND `status`='success'");
                list($user_id2,$date_accept2)=mysqli_fetch_row($sqli5);
                $sqli6=$conn->query("SELECT `name`,`surname` FROM `tbl_employee` WHERE `id`='$user_id2'");
                list($name2,$surname2)=mysqli_fetch_row($sqli6);

                ?>
                <div class="row">
                    <div class="col-md-3 text-center">
                        <img src="img/wait-1.png" class="mimg100" alt=""><br><br>
                        <h5>ผู้สั่งจอง : <?=$name." ".$surname?></h5>
                        <h6><?=$date_order?></h6>
                    </div>
                    <div class="col-md-3 text-center">
                        <img src="img/confirm-1.png" class="mimg100" alt=""><br><br>
                        <h5>ผู้ยืนยัน : <?=$name1." ".$surname1?></h5>
                        <h6><?=$date_accept?></h6>
                    </div>
                    <div class="col-md-3 text-center">
                        <img src="img/delivery-1.png" class="mimg100" alt=""><br><br>
                    </div>
                    <div class="col-md-3 text-center">
                        <img src="img/success-1.png" class="mimg100" alt=""><br><br>
                        <h5>ผู้รับรถ : <?=$name2." ".$surname2?></h5>
                        <h6><?=$date_accept2?></h6>
                    </div>
                </div>
                <?php
            }else if($status=="failed")
            {
                $sqli3=$conn->query("SELECT `user_id`,`date_accept` FROM `tbl_accept` WHERE `order_id`='$order_id' AND `status`='failed'");
                list($user_id1,$date_accept)=mysqli_fetch_row($sqli3);
                $sqli4=$conn->query("SELECT `name`,`surname` FROM `tbl_employee` WHERE `id`='$user_id1'");
                list($name1,$surname1)=mysqli_fetch_row($sqli4);
               

                ?>
                <div class="row">
                    <div class="col-md-3 text-center">
                        <img src="img/wait-0.png" class="mimg100" alt=""><br><br>
                        <h5>ผู้สั่งจอง : <?=$name." ".$surname?></h5>
                        <h6><?=$date_order?></h6>
                    </div>
                    <div class="col-md-3 text-center">
                        <img src="img/confirm-0.png" class="mimg100" alt=""><br><br>

                    </div>
                    <div class="col-md-3 text-center">
                        <img src="img/delivery-0.png" class="mimg100" alt=""><br><br>
                    </div>
                    <div class="col-md-3 text-center">
                        <img src="img/failed.png" class="mimg100" alt=""><br><br>
                        <h5>ผู้ปฏิเสธ : <?=$name1." ".$surname1?></h5>
                        <h6><?=$date_accept?></h6>
                    </div>
                </div>
                <?php
            }
            ?>

            </div>
        </div>

    </div>







    <div class="container mt-5">
        <hr>
        <div class="row mt-5">
            <div class="col-12">

                <h4>ประวัติการทำรายการ</h4>

            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-hover table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>ทำรายการ</th>
                            <th>ชื่อผู้ดำเนินการ</th>
                            <th>หมายเหตุ</th>
                            <th>เวลา</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>สั่งจองรถ</td>
                            <td><?=$name." ".$surname?></td>
                            <td><?=$note?></td>
                            <td><?=$date_order?></td>
                        </tr>
                        <?php
                        $n=2;
                    $sqli=$conn->query("SELECT `accept_id`, `order_id`, `user_id`, `status`, `note`, `date_accept` FROM `tbl_accept` WHERE `order_id`='$order_id' ORDER BY `date_accept` asc");
                    if($sqli->num_rows>0)
                    {
                        while ($row=$sqli->fetch_assoc()) {
                            $userID=$row['user_id'];
                            $sqli2=$conn->query("SELECT `name`,`surname` FROM `tbl_employee` WHERE `id`='$userID'");
list($name,$surname)=mysqli_fetch_row($sqli2);

                            ?>
                            <tr>
                            <td><?=$n?></td>
                            <td><?=$arr_status[$row['status']]?></td>
                            <td><?=$name." ".$surname?></td>
                            <td><?=$row['note']?></td>
                            <td><?=$row['date_accept']?></td>
                            </tr>
                        <?php
                        }
                    }
                    ?>
                    </tbody>


                </table>

            </div>
        </div>
    </div>
</div>

<?php
    include("footer.php");

    ?>