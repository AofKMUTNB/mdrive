<?php
include("head.php");

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
                <form id="form_add_mortor_stock">
                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <span>ชื่อรุ่น *</span>
                            <input type="text" class="form-control" name="name" required>
                        </div>

                        <div class="col-lg-4 form-group">
                            <span>CODE *</span>
                            <input type="text" class="form-control" name="code" required>
                        </div>
                        <div class="col-lg-4 form-group">
                            <span>ยี่ห้อ *</span>
                            <select name="brand" class="form-control" required>
                                <option value="" selected disabled>เลือก</option>
                                <option value="HONDA">HONDA</option>
                                <option value="YAMAHA">YAMAHA</option>
                            </select>
                        </div>
                        <div class="col-lg-4 form-group">
                            <span>ประเภท *</span>
                            <select name="type" class="form-control" required>
                                <option value="" selected disabled>เลือก</option>
                                <option value="Family">Family</option>
                                <option value="Automatic">Automatic</option>
                                <option value="Sport">Sport</option>
                            </select>
                        </div>
                        <div class="col-lg-12 form-group">
                            <i>** ระบุสีรถอย่างน้อย 1 สี**</i>
                            <button class="btn btn-info" onclick="add_column()" type="button"><span class="fa fa-plus"></span></button>
                            <input type="hidden" id="c_color" name="c_color" value='1'>
                        </div>


                        <div class="col-12">
                        <div class="row list-column">
                        <div class="col-lg-2 form-group" id="c1">
                            <span>สี </span>
                            <input type="text" class="form-control" id="color[1]" name='color[1]' required>
                            <span>จำนวน </span>
                            <div class="row">
                                <div class="col-md-3 col-2 text-right p-0 pr-2">
                                    <a onclick="minus(1)"><span class="fa fa-minus-square f20 mt-2"></span></a>
                                </div>
                                <div class="col-md-6 col-8 p-0  text-center">
                                    <input type="number" class="form-control" name="unit[1]" id="unit1" value="0" min="1" required>
                                </div>
                                <div class="col-md-3 col-2 text-left p-0 pl-2">
                                    <a onclick="plus(1)"><span class="fa fa-plus-square f20 mt-2"></span></a>
                                </div>
                                <div class="col-12 text-center mt-2">
                                </div>

                            </div>
                        </div>
                        </div>
                        
                        </div>




                      



                        <div class="col-lg-12 mt-3 mb-3 text-center">
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



<script>
    $(document).ready(function () {
        $("#form_add_mortor_stock").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this); 
            formData.append("act", "form_add_mortor_stock");
            $.ajax({
                url: "sql/add_mortor_stock.php", 
                type: "POST",
                data: formData,
                success: function (data) {
                    alert_success(
                        "success",
                        "Success",
                        "ทำรายการสำเร็จ ",
                        "motorcycle.php"
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
    function add_column() {
        var c_color=$("#c_color").val();
        $.ajax({
                url: "add_column.php", 
                type: "POST",
                data: {
                    id:c_color
                },
                success: function (data) {
                    $("#c_color").val(parseInt(c_color)+1);

                    $(".list-column").append(data);
                   
                }
            });

    }
    function del_column(id) {
       $("#c"+id).remove();

    }
</script>