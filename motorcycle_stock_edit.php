<?php
include("head.php");
$motor_id=$_GET['motor_id'];
$sqli=$conn->query("SELECT `color_id`, `motor_id`, `color_name`, `stock` FROM `motorcycle_color_center` WHERE `motor_id`='$motor_id'");
$num_coloum=$sqli->num_rows;
$sqli2=$conn->query("SELECT `id`, `type`, `brand`, `code`, `name`, `update_at` FROM `motorcycle_center` WHERE `id`='$motor_id'");
while ($row=$sqli2->fetch_assoc()) {

?>


<div class="breadcrumbs-area mb-20">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumbs-menu">
                    <ul>
                        <li><a href="#">หน้าหลัก</a></li>

                        <li><a href="motorcycle.php" class="">รายการรถจักรยานยนต์</a>
                        </li>
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
                <form id="form_edit_mortor_stock">
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
                            <?php
                            if($row['brand']=="HONDA"){$ck1="selected";}else{$ck1="";}
                            if($row['brand']=="YAMAHA"){$ck2="selected";}else{$ck2="";}
                            ?>
                            <select name="brand" class="form-control" required>
                                <option value="" disabled>เลือก</option>
                                <option value="HONDA" <?=$ck1?>>HONDA</option>
                                <option value="YAMAHA" <?=$ck2?>>YAMAHA</option>
                            </select>
                        </div>
                        <div class="col-lg-4 form-group">
                            <span>ประเภท *</span>
                            <?php
                            if($row['type']=="Family"){$ck1="selected";}else{$ck1="";}
                            if($row['type']=="Automatic"){$ck2="selected";}else{$ck2="";}
                            if($row['type']=="Sport"){$ck3="selected";}else{$ck3="";}
                            ?>
                            <select name="type" class="form-control" required>
                                <option value="" selected disabled>เลือก</option>
                                <option value="Family" <?=$ck1?>>Family</option>
                                <option value="Automatic" <?=$ck2?>>Automatic</option>
                                <option value="Sport" <?=$ck3?>>Sport</option>
                            </select>
                        </div>
                        <div class="col-lg-12 form-group">
                            <i>** ระบุสีรถอย่างน้อย 1 สี**</i>
                            <button class="btn btn-info" onclick="add_column_edit()" type="button"><span
                                    class="fa fa-plus"></span></button>
                            <input type="hidden" id="c_color" name="c_color" value='<?=$num_coloum?>'>
                        </div>


                        <div class="col-12">
                            <div class="row list-column">
                            <?php
                            $i=1;
                            if($num_coloum>0)
                            {
                                while ($r=$sqli->fetch_assoc()) {
                                    ?>
                                    <div class="col-lg-2 form-group" id="c<?=$i?>">
                                    <input type="hidden" name="color_id[<?=$i?>]" value="<?=$r['color_id']?>">
                                    <span>สี </span>
                                    <input type="text" class="form-control" id="color[<?=$i?>]" name='color[<?=$i?>]' required value="<?=$r['color_name']?>">
                                    <span>จำนวน </span>
                                    <div class="row">
                                        <div class="col-md-3 col-2 text-right p-0 pr-2">
                                            <a onclick="minus(<?=$i?>)"><span class="fa fa-minus-square f20 mt-2"></span></a>
                                        </div>
                                        <div class="col-md-6 col-8 p-0  text-center">
                                            <input type="number" class="form-control" name="unit[<?=$i?>]" id="unit<?=$i?>"
                                                value="<?=$r['stock']?>" min="1" required>
                                        </div>
                                        <div class="col-md-3 col-2 text-left p-0 pl-2">
                                            <a onclick="plus(<?=$i?>)"><span class="fa fa-plus-square f20 mt-2"></span></a>
                                        </div>
                                        <div class="col-12 text-center mt-2">
                                        <?php
                                        if($i!=1)
                                        {
                                            ?>
                                            <button class="btn btn-danger" onclick="how_del_co(<?=$r['color_id']?>)" type="button"><span class="fa fa-trash"></span></button>
                                            <?php
                                        }
                                        ?>
                                        </div>

                                    </div>
                                </div>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                                
                            </div>

                        </div>








                        <div class="col-lg-12 mt-3 mb-3 text-center">
                        <input type="hidden" name="id" value="<?=$motor_id?>">
                            <button type="button" onclick="location.reload();" class="btn btn-danger">ล้าง</button>
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
        $("#form_edit_mortor_stock").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "sql/edit_mortor_stock.php",
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

    function add_column_edit() {
        var c_color = $("#c_color").val();
        $.ajax({
            url: "add_column_edit.php",
            type: "POST",
            data: {
                id: c_color
            },
            success: function (data) {
                $("#c_color").val(parseInt(c_color) + 1);

                $(".list-column").append(data);

            }
        });

    }

    function how_del_co(id) {
        Swal.fire({
        title: "คุณต้องการลบข้อมูลใช่หรือไม่?",
        text: "ข้อมูลทั้งหมดที่เกี่ยวข้องกับรหัสนี้ จะถูกลบออกทั้งหมดทันที",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "ใช่ ลบเลย!",
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "sql/del_color.php",
                type: "post",
                data: {
                    ids: id
                },
                success: function(data) {
                    Swal.fire({
                        icon: "success",
                        title: "ทำรายการสำเร็จ",
                        text: "",
                    }).then((result) => {
                        if (result.value) {
                            location.reload();

                        }
                    });
                },
            });
        }
    });

    }
</script>