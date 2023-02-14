<?php
include("head.php");
if(empty($_SESSION['user-id'])){echo "<script>window.location='login.php'</script>";}
$branch_id=$_GET['branch_id'];
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
                        <li><a href="motorcycle_list.php?branch_id=<?=$branch_id?>" class="">รายการรถจักรยานยนต์</a>
                        </li>
                        <li><a href="#" class="active">เพิ่มรถจักรยานยนต์</a></li>
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
                <h3>เพิ่มรถจักรยานยนต์</h3>
            </div>
            <div class="col-lg-12">
                <form id="form_add_mortor">
                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <span>ชื่อรุ่น *</span>
                            <select class="js-example-basic-single form-control" name="name" id="name"
                                onchange="show_data()">
                                <option value="">เลือก</option>

                                <?php
                                    $sqli = $conn->query("SELECT `name`,`id` FROM `motorcycle_center` ");
                                    while ($r=$sqli->fetch_assoc()) {
                                        ?>
                                                <option value="<?=$r['id']?>"><?=$r['name']?></option>

                                                <?php
                                    }

                                    ?>
                            </select>
                        </div>

                        <div class="col-lg-4 form-group">
                            <span>CODE *</span>
                            <input type="text" class="form-control" name="code" id="code" disabled>
                        </div>
                        <div class="col-lg-4 form-group">
                            <span>ยี่ห้อ *</span>
                            <select name="brand" id="brand" class="form-control" disabled>
                                <option value="" selected disabled>เลือก</option>
                                <option value="HONDA">HONDA</option>
                                <option value="YAMAHA">YAMAHA</option>
                            </select>
                        </div>
                        <div class="col-lg-4 form-group">
                            <span>ประเภท *</span>
                            <select name="type" id="type" class="form-control" disabled>
                                <option value="" selected disabled>เลือก</option>
                                <option value="Family">Family</option>
                                <option value="Automatic">Automatic</option>
                                <option value="Sport">Sport</option>
                            </select>
                        </div>
                        <div class="col-lg-12 form-group">
                            <i>** ระบุสีรถอย่างน้อย 1 สี**</i>
                            <button class="btn btn-info" onclick="add_column()" type="button"><span
                                    class="fa fa-plus"></span></button>
                            <input type="hidden" id="c_color" name="c_color" value='1'>
                        </div>


                        <div class="col-12">
                            <div class="row list-column">
                                <div class="col-lg-2 form-group" id="c1">
                                    <span>สี <i id="txt1" style="color:red;"></i> </span>
                                        <input type="hidden" name="max_unit1" id="max_unit1">                          <!--ตัวหนังสือแดงเตือนจำนวนรถในคลังเหลือ-->   

                                    <select class="form-control color" id="color1" name='color[1]' onchange="change_color(1)">       
                                    </select>
                                    <span>จำนวน </span>
                                    <div class="row">
                                        <div class="col-md-3 col-2 text-right p-0 pr-2">                                             
                                            <a onclick="minus(1)"><span class="fa fa-minus-square f20 mt-2"></span></a>              <!--ปุ่มลบ-->
                                        </div>
                                        <div class="col-md-6 col-8 p-0  text-center">
                                            <input type="number" onchange="chang_unit(1)" class="form-control" name="unit[1]" id="unit1"
                                                value="0" min="1" required>                                                          <!--ช่องใส่เลข-->
                                        </div>
                                        <div class="col-md-3 col-2 text-left p-0 pl-2">
                                            <a onclick="plus(1)"><span class="fa fa-plus-square f20 mt-2"></span></a>                <!--ปุ่มบวก-->
                                        </div>
                                        <div class="col-12 text-center mt-2">
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>




                        <div class="col-lg-12 mt-3 mb-3 text-center">
                            <input type="hidden" name="branch_id" value="<?=$branch_id?>">
                            <input type="hidden" name="motor_id" id="motor_id" >
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
                    url: "sql/add_mortor_branch.php",
                    type: "POST",
                    data: formData,
                    success: function (data) {
                        console.log(data);
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
    function chang_unit(id) {                   //เมื่อกดแก้ไข
        var unit = $("#unit" + id).val();
        if (unit == null) {
            unit = 0;
        }
        if(parseInt(unit) <=$("#max_unit"+id).val() && parseInt(unit) >0)
        {

            var newunit = parseInt(unit);
            $("#unit" + id).val(newunit);
            $("#txt" + id).html("รถในคลังมี "+($("#max_unit"+id).val()-newunit)+' คัน');
        }else if(parseInt(unit)  > 0 && parseInt(unit) >$("#max_unit"+id).val()){
            $("#unit" + id).val($("#max_unit"+id).val());
            $("#txt" + id).html("รถในคลังมี 0 คัน");

        }else{
            $("#unit" + id).val(0);
            $("#txt" + id).html("รถในคลังมี "+$("#max_unit"+id).val()+" คัน");

        }
        

    }



    function minus(id) {                            //ลบ
        var unit = $("#unit" + id).val();
        if (unit == null) {
            unit = 0;
        }
        if (parseInt(unit)  > 0 && parseInt(unit) <=$("#max_unit"+id).val()) {
            var newunit = parseInt(unit) - 1;
            $("#unit" + id).val(newunit);
            $("#txt" + id).html("รถในคลังมี "+($("#max_unit"+id).val()-newunit)+' คัน');
        }else if(parseInt(unit)  > 0 && parseInt(unit) >$("#max_unit"+id).val()){
            $("#unit" + id).val($("#max_unit"+id).val());
            $("#txt" + id).html("รถในคลังมี 0 คัน");

        }else{
            $("#unit" + id).val(0);
            $("#txt" + id).html("รถในคลังมี "+$("#max_unit"+id).val()+" คัน");

        }

    }




    function plus(id) {                             //เพิ่ม
        var unit = $("#unit" + id).val();
        if (unit == null) {
            unit = 0;
        }
        if (parseInt(unit)  >= 0 && parseInt(unit) < $("#max_unit"+id).val()) {
            var newunit = parseInt(unit) + 1;
            $("#unit" + id).val(newunit);
            $("#txt" + id).html("รถในคลังมี "+($("#max_unit"+id).val()-newunit)+' คัน');
        }else if(parseInt(unit)  >= 0 && parseInt(unit) > $("#max_unit"+id).val()){    //เพิ่มเต็มMax =จำนวนที่เพิ่มมากกว่าจำนวนในคลัง
            $("#unit" + id).val($("#max_unit"+id).val());
            $("#txt" + id).html("รถในคลังมี 0 คัน");

        }else{
            $("#unit" + id).val(0);
            $("#txt" + id).html("รถในคลังมี "+$("#max_unit"+id).val()+" คัน");

        }
      

    }
    function del_column(id) {
       $("#c"+id).remove();

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
                    tbody += "<option value='" + obj[i]['color_id'] + "'>" + obj[i]['color_name'] + "</option>";
                }
                $(".color").html(tbody);


            }
        });

    }



    function add_column() {
        if($("#name").val()!="")
        {

            var c_color = $("#c_color").val();
        $.ajax({
            url: "add_column_s.php",
            type: "POST",
            data: {
                id: c_color,motor_id:$("#name").val()
            },
            success: function (data) {
                $("#c_color").val(parseInt(c_color) + 1);

                $(".list-column").append(data);

            }
        });
        }
        

    }
    function change_color(id) {
        var color_id=$("#color"+id).val();
        $.ajax({
            url: "sql/load_max_color.php",
            type: "POST",
            data: {
                id: color_id
            },
            success: function (data) {
                var obj=JSON.parse(data);
                $("#unit"+id).attr({
       "max" : obj['stock'],        // substitute your own
       "min" : 1          // values (or variables) here
    });
    $("#txt" + id).html("รถในคลังมี "+obj['stock']+' คัน');
    $("#max_unit" + id).val(obj['stock']);

        
            }
        });


      

    }
</script>