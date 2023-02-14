<?php
include("head.php");
if(empty($_SESSION['user-id'])){echo "<script>window.location='login.php'</script>";}
$motor_id=$_GET['motor_id'];

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
                        <li><a href="motorcycle_list.php?branch_id=<?=$row['branch_id']?>"
                                class="">รายการรถจักรยานยนต์</a></li>
                        <li><a href="#" class="active">แก้ไขรถจักรยานยนต์</a></li>
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
                <h3>แก้ไขรถจักรยานยนต์</h3>
            </div>
            <div class="col-lg-12">
                <form id="form_edit_mortor">
                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <span>ชื่อรุ่น *</span>
                            <input type="text" class="form-control" name="name" required value="<?=$row['name']?>">
                        </div>

                        <div class="col-lg-4 form-group">
                            <span>CODE *</span>
                            <input type="text" class="form-control" name="code" required value="<?=$row['code']?>">
                        </div>
                        <div class="col-lg-4 form-group">
                            <span>ยี่ห้อ *</span>
                            <?php $chk1="";$chk2="";
                            if($row['brand']=="HONDA"){$chk1="selected";}else{$chk2="selected";}
                            ?>
                            <select name="brand" class="form-control" required>
                                <option value="" disabled>เลือก</option>
                                <option value="HONDA" <?=$chk1?>>HONDA</option>
                                <option value="YAMAHA" <?=$chk2?>>YAMAHA</option>
                            </select>
                        </div>
                        <div class="col-lg-4 form-group">
                            <span>ประเภท *</span>
                            <?php $chk1="";$chk2="";$chk3="";
                            if($row['type']=="Family"){$chk1="selected";}else if($row['type']=="Automatic"){$chk2="selected";}else{$chk3="selected";}
                            ?>
                            <select name="type" class="form-control" required>
                                <option value="" selected disabled>เลือก</option>
                                <option value="Family" <?=$chk1?>>Family</option>
                                <option value="Automatic" <?=$chk2?>>Automatic</option>
                                <option value="Sport" <?=$chk3?>>Sport</option>
                            </select>
                        </div>
                        <div class="col-lg-12 form-group">
                            <i>** ระบุสีรถอย่างน้อย 1 สี**</i>
                        </div>
                        <?php
                         $sqlie=$conn->query("SELECT * FROM `tbl_motorcycle_color` WHERE `mainID`='$motor_id'");
                         $i=1;
                         while ($rr=$sqlie->fetch_assoc()) {
                             if($rr['unit']==0){$rr['unit']="";}
                           ?>
                        <div class="col-lg-2 form-group">
                            <span>สี </span>
                                <select name="color[<?=$i?>]" class="form-control">
                                    <option value="" selected disabled>เลือก</option>
                                    <?php
                                    for ($ii=0; $ii <count($arr_color) ; $ii++) { 
                                        if($rr['color']==$arr_color[$ii]){$chk="selected";}else{$chk="";}
                                        ?>
                                    <option value="<?=$arr_color[$ii]?>" <?=$chk?>><?=$arr_color[$ii]?></option>
                                    <?php
                                    }
                                        ?>
                                </select>
                                <?php
                                if(empty($rr['unit'])){$rr['unit']=0;}
                                ?>
                            <span>จำนวน </span>
                            <div class="row">
                                <div class="col-md-3 col-2 text-right p-0 pr-2">
                                    <a onclick="minus(<?=$i?>)"><span class="fa fa-minus-square f20 mt-2"></span></a>
                                </div>
                                <div class="col-md-6 col-8 p-0  text-center">
                                    <input type="number" class="form-control" name="unit[<?=$i?>]" id="unit<?=$i?>" value="<?=$rr['unit']?>">
                                </div>
                                <div class="col-md-3 col-2 text-left p-0 pl-2">
                                    <a onclick="plus(<?=$i?>)"><span class="fa fa-plus-square f20 mt-2"></span></a>
                                </div>

                            </div>

                            <input type="hidden" name="idcolor[<?=$i?>]" value="<?=$rr['id']?>">
                        </div>
                        <?php
                        $i++;
                         }
                        ?>

                        <div class="col-lg-12 mt-3 mb-3 text-center">
                            <input type="hidden" name="mortor_id" value="<?=$mortor_id?>">
                            <button type="reset" class="btn btn-danger">ล้าง</button>
                            <button type="submit" class="btn btn-success">บันทึก</button>

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
        $("#form_edit_mortor").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append("act", "form_edit_mortor");
            $.ajax({
                url: "sql.php",
                type: "POST",
                data: formData,
                success: function (data) {
                    console.log(data);
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

    function plus(id) {
        var unit = $("#unit" + id).val();
        if (unit == null) {
            unit = 0;
        }
        var newunit = parseInt(unit) + 1;
        $("#unit" + id).val(newunit);
    }

    function minus(id) {
        var unit = $("#unit" + id).val();
        if (unit == null) {
            unit = 0;
        }
        if (unit > 0) {
            var newunit = parseInt(unit) - 1;
            $("#unit" + id).val(newunit);
        }

    }
</script>