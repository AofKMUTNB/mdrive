<?php
include("head.php");
if(empty($_SESSION['user-id'])){echo "<script>window.location='login.php'</script>";}
$mainID=$_GET['motor_id'];

$sqli2=$conn->query("SELECT `id`, `mainID`, `color_id`, `color`,`unit` FROM `tbl_motorcycle_color` WHERE `mainID`='$mainID'");
$num_coloum=$sqli2->num_rows;

$sqli=$conn->query("SELECT * FROM `tbl_motorcycle` WHERE `id`='$mainID'");
while ($main=$sqli->fetch_assoc()) {
    $branch_id=$main['branch_id'];
    $motor_id=$main['motor_id'];
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
                        <li><a href="motorcycle_list.php?branch_id=<?=$main['branch_id']?>"
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
                <form id="form_add_mortor">
                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <span>ชื่อรุ่น *</span>
                            <select class="js-example-basic-single form-control" name="name" id="name"
                                onchange="show_data()" disabled>
                                <option value="">เลือก</option>

                                <?php
                                    $sqli = $conn->query("SELECT `name`,`id` FROM `motorcycle_center` ");
                                    while ($r=$sqli->fetch_assoc()) {
                                        if($main['motor_id']==$r['id']){$ck="selected";}else{$ck="";}
                                        ?>
                                <option value="<?=$r['id']?>" <?=$ck?>><?=$r['name']?></option>
                                <?php
                                    }

                                    ?>
                            </select>
                        </div>

                        <div class="col-lg-4 form-group">
                            <span>CODE *</span>
                            <input type="text" class="form-control" name="code" id="code" disabled
                                value="<?=$main['code']?>">
                        </div>
                        <div class="col-lg-4 form-group">
                            <span>ยี่ห้อ *</span>
                            <?php
                            if($main['brand']=="HONDA"){$ck1="selected";}else{$ck1="";}
                            if($main['brand']=="YAMAHA"){$ck2="selected";}else{$ck2="";}
                            ?>

                            <select name="brand" id="brand" class="form-control" required disabled>
                                <option value="HONDA" <?=$ck1?>>HONDA</option>
                                <option value="YAMAHA" <?=$ck2?>>YAMAHA</option>
                            </select>
                        </div>
                        <div class="col-lg-4 form-group">
                            <span>ประเภท *</span>
                            <?php
                            if($main['type']=="Family"){$ck1="selected";}else{$ck1="";}
                            if($main['type']=="Automatic"){$ck2="selected";}else{$ck2="";}
                            if($main['type']=="Sport"){$ck3="selected";}else{$ck3="";}
                            ?>

                            <select name="type" id="type" class="form-control" required disabled>
                                <option value="Family" <?=$ck1?>>Family</option>
                                <option value="Automatic" <?=$ck2?>>Automatic</option>
                                <option value="Sport" <?=$ck3?>>Sport</option>
                            </select>
                        </div>
                        <div class="col-lg-12 form-group">
                            <i>** ระบุสีรถอย่างน้อย 1 สี**</i>
                            <button class="btn btn-info" onclick="add_column()" type="button"><span
                                    class="fa fa-plus"></span></button>
                            <input type="hidden" id="c_color" name="c_color" value='<?=$num_coloum?>'>
                        </div>


                        <div class="col-12">
                            <div class="row list-column">
                                <?php
                            $i=1;
                            if($num_coloum>0)
                            {
                                while ($r=$sqli2->fetch_assoc()) {
                                    $co=$conn->query("SELECT `color_id`, `motor_id`, `color_name`, `stock` FROM `motorcycle_color_center` WHERE `motor_id`='$motor_id'");
                                    $co2=$conn->query("SELECT  `stock` FROM `motorcycle_color_center` WHERE `motor_id`='$motor_id'");
                                    list($stock)=mysqli_fetch_row($co2);
                                    ?>
                                <div class="col-lg-2 form-group" id="c<?=$i?>">
                                    <input type="hidden" name="color_id[<?=$i?>]" value="<?=$r['id']?>">
                                    <span>สี </span>
                                    <select class="form-control color" id="color<?=$i?>" name='color[<?=$i?>]'
                                        onchange="change_color(<?=$i?>)">
                                        <option value="">เลือก</option>
                                        <?php
                                   
                                    while ($cc=$co->fetch_assoc()) {
                                        if($r['color_id']==$cc['color_id']){$ck="selected";}else{$ck="";}
                                        ?>
                                        <option value="<?=$cc['color_id']?>" <?=$ck?>><?=$cc['color_name']?></option>
                                        <?php
                                    }
                                    ?>
                                    </select>
                                    <span>จำนวน </span>
                                    <div class="row">
                                        <div class="col-md-3 col-2 text-right p-0 pr-2">
                                            <a onclick="minus(<?=$i?>)"><span
                                                    class="fa fa-minus-square f20 mt-2"></span></a>
                                        </div>
                                        <div class="col-md-6 col-8 p-0  text-center">
                                            <input type="number" class="form-control" name="unit[<?=$i?>]"
                                                id="unit<?=$i?>" value="<?=$r['unit']?>" min="1"
                                                max="<?=($stock+$r['unit'])?>" required>
                                        </div>
                                        <div class="col-md-3 col-2 text-left p-0 pl-2">
                                            <a onclick="plus(<?=$i?>)"><span
                                                    class="fa fa-plus-square f20 mt-2"></span></a>
                                        </div>
                                        <div class="col-12 text-center mt-2">
                                            <?php
                                        if($i!=1)
                                        {
                                            ?>
                                            <button class="btn btn-danger" onclick="how_del_co(<?=$r['color_id']?>)"
                                                type="button"><span class="fa fa-trash"></span></button>
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
                            <input type="hidden" name="branch_id" value="<?=$branch_id?>">
                            <input type="hidden" name="mainID" value="<?=$mainID?>">
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


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<!-- นำเข้า Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>


<script>
    $('.js-example-basic-single').select2();

    $(document).ready(function () {
        $("#form_add_mortor").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "sql/edit_mortor_branch.php",
                type: "POST",
                data: formData,
                success: function (data) {
                    alert_success(
                        "success",
                        "Success",
                        "ทำรายการสำเร็จ ",
                        "motorcycle_list.php?branch_id=<?=$branch_id?>"
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

    function show_data() {
        var mortor_id = $("#name").val();
        $.ajax({
            url: "sql/show_data_motor.php",
            type: "POST",
            data: {
                ids: mortor_id
            },
            success: function (data) {
                var obj = JSON.parse(data);
                $("#code").val(obj['code']);
                $("#brand").val(obj['brand']);
                $("#type").val(obj['type']);
                $("#motor_id").val(obj['id']);
                load_color(mortor_id);

            }
        });

    }

    function load_color(motor_id) {
        $.ajax({
            url: "sql/show_data_motor_color.php",
            type: "POST",
            data: {
                ids: motor_id
            },
            success: function (data) {
                var obj = JSON.parse(data);
                var tbody = "<option value=''>เลือก</option>";
                for (var i = 0; i < obj['num_data']; i++) {
                    tbody += "<option value='" + obj[i]['color_id'] + "'>" + obj[i]['color_name'] +
                        "</option>";
                }
                $(".color").html(tbody);


            }
        });

    }



    function add_column() {
        if ($("#name").val() != "") {

            var c_color = $("#c_color").val();
            $.ajax({
                url: "add_column_s.php",
                type: "POST",
                data: {
                    id: c_color,
                    motor_id: $("#name").val()
                },
                success: function (data) {
                    $("#c_color").val(parseInt(c_color) + 1);

                    $(".list-column").append(data);

                }
            });
        }


    }

    function change_color(id) {
        var color_id = $("#color" + id).val();
        console.log(color_id);
        $.ajax({
            url: "sql/load_max_color.php",
            type: "POST",
            data: {
                id: color_id
            },
            success: function (data) {
                var obj = JSON.parse(data);
                $("#unit" + id).attr({
                    "max": obj['stock'], // substitute your own
                    "min": 1 // values (or variables) here
                });

            }
        });




    }
</script>