<?php
include("head.php");
if(empty($_SESSION['user-id'])){echo "<script>window.location='login.php'</script>";}
$order_id=$_GET['order_id'];

$sqli1=$conn->query("SELECT `branch_order`,`motor_id`,`color_id`,`unit`,`note` FROM `tbl_order` WHERE `id`='$order_id'");
list($branch_order,$motor_id,$color_id,$getunit,$note)=mysqli_fetch_row($sqli1);
$sqli=$conn->query("SELECT * FROM `tbl_motorcycle` WHERE `id`='$motor_id'");
while ($row=$sqli->fetch_assoc()) {
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
                        <li><a href="order_list.php?branch_id=<?=$branch_order?>">รายการสั่งจองรถจักรยานยนต์</a></li>
                        <li><a href="#" class="active">แก้ไขการสั่งจอง</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="cart-main-area mb-10">
    <div class="container">

        <div class="row">
            <div class="col-lg-12 text-center">
                <h3>แก้ไขการสั่งจอง</h3>
            </div>
            <div class="col-lg-12 mt-3">
                <form id="form_order_edit">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <span>ชื่อรุ่น *</span>
                           <h6><?=$row['name']?></h6>
                        </div>

                        <?php
                         $branch_id=$row['branch_id'];
                         $sql2=$conn->query("SELECT a.branch_name,b.zone_name FROM `tbl_branch` a inner join tbl_zone b on a.zone_id=b.id WHERE a.id='$branch_id'");
                         list($branch_name,$zone_name)=mysqli_fetch_row($sql2);
                        ?>
                        <div class="col-lg-6 form-group">
                            <span>สาขา *</span>
                           <h6>[ <?=$zone_name?> ] <?=$branch_name?></h6>
                        </div>

                        <div class="col-lg-3 form-group">
                            <span>CODE *</span>
                            <h6><?=$row['code']?></h6>
                        </div>
                        <div class="col-lg-3 form-group">
                            <span>ยี่ห้อ *</span>
                           <h6><?=$row['brand']?></h6>
                        </div>
                        <div class="col-lg-3 form-group">
                            <span>ประเภท *</span>
                            <h6><?=$row['type']?></h6>
                        </div>
                       
                        <?php
                         $sqlie=$conn->query("SELECT color,unit FROM `tbl_motorcycle_color` WHERE `id`='$color_id'");
                        list($color,$unit)=mysqli_fetch_row($sqlie);
                        ?>
                        <div class="col-lg-3 form-group">
                            <span>สีที่สั่งจอง *</span>
                            <h6><?=$color?></h6>
                        </div>
                        <div class="col-12 ">
                            <hr>
                            <p class="fred">จำนวนคงเหลือ <?=$unit?> คัน</p>

                        </div>
                        <div class="col-lg-6 form-group">
                            <div class="">
                            <i>** ระบุจำนวนที่ต้องการสั่งจอง**</i>
                            <div class="row">
                                <div class="col-md-1 col-2 text-right p-0 pr-2">
                                    <a onclick="minus()"><span class="fa fa-minus-square f20 mt-2"></span></a>
                                </div>
                                <div class="col-md-6 col-8 p-0  text-center">
                                    <input type="number" class="form-control" name="getunit" id="getunit" value="<?=$getunit?>" min="1" max="<?=$unit?>" required>
                                </div>
                                <div class="col-md-1 col-2 text-left p-0 pl-2">
                                    <a onclick="plus()"><span class="fa fa-plus-square f20 mt-2"></span></a>
                                </div>

                            </div>

                            </div>
                        </div>
                        <?php
                                if($_SESSION['user-type']=="admin")
                                {
                                    ?>
                                        <div class="col-lg-6 form-group">   
                                        <span>จองให้สาขา</span>
                                        <select name="branch_id" class="form-control" required id="">
                                        <option value="" selected disabled>เลือก</option>
                                            <?php
                                        $sql=$conn->query("SELECT * FROM `tbl_zone` order by id asc");
                                        while ($r=$sql->fetch_assoc()) {
                                            $zone_id=$r['id'];
                                            $sql2=$conn->query("SELECT * FROM `tbl_branch` WHERE `zone_id`='$zone_id' and id!='$branch_id'");
                                            while ($row=$sql2->fetch_assoc()) {
                                                if($branch_order==$row['id']){$chk="selected";}else{$chk="";}
                                                ?>
                                            <option value="<?=$row['id']?>" <?=$chk?>>[<?=$r['zone_name']?>] <?=$row['branch_name']?></option>
                                            <?php
                                            }
                                        }
                                        ?>
                                        </select>
                                    </div>
                                    <?php

                                }else{
                                    ?>
                                         <input type="hidden" name="branch_id" value="">
                                    <?php
                                }
                        ?>
                         <div class="col-12">
                            <span>หมายเหตุ</span>
                            <textarea name="note" class="form-control" id="" cols="30" placeholder="ไม่ระบุ" rows="5"><?=$note?></textarea>
                        </div>

                        <div class="col-lg-12 mt-3 mb-3 text-center">
                            <input type="hidden" name="order_id" value="<?=$order_id?>">
                            <button type="reset" class="btn btn-danger">ล้าง</button>
                            <button type="submit" class="btn btn-success">ยืนยัน</button>

                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<?php
}
    include("footer.php");

    ?>



<script>
    $(document).ready(function () {
        $("#form_order_edit").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append("act", "form_order_edit");
            $.ajax({
                url: "sql.php",
                type: "POST",
                data: formData,
                success: function (data) {
                    alert_success(
                        "success",
                        "Success",
                        "ทำรายการสำเร็จ ",
                        "reload"
                    );
                },
                cache: false,
                contentType: false,
                processData: false,
            });
        });


    });


    function plus() {
        var unit = $("#getunit").val();
        if (unit == null) {
            unit = 0;
        }
        var newunit = parseInt(unit) + 1;
        $("#getunit").val(newunit);
    }

    function minus() {
        var unit = $("#getunit").val();
        if (unit == null) {
            unit = 0;
        }
        if (unit > 0) {
            var newunit = parseInt(unit) - 1;
            $("#getunit").val(newunit);
        }

    }
</script>