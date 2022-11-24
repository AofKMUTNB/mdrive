
<?php
include("head.php");
if(empty($_SESSION['user-id'])){echo "<script>window.location='login.php'</script>";}
isset( $_POST['color_id'] ) ? $color_id = $_POST['color_id'] : $color_id = "";

$ck1="";$ck2="";$ck3="";$ck4="";$ck5="";
if(empty($_GET['branch_id']))
{
    $my_branch=$_SESSION['user-branch'];
}else{
    $my_branch=$_GET['branch_id'];

}

$sql2=$conn->query("SELECT a.branch_name,b.zone_name FROM `tbl_branch` a inner join tbl_zone b on a.zone_id=b.id WHERE a.id='$my_branch' ");
    list($branch_name,$zone_name)=mysqli_fetch_row($sql2);

    if(empty($_GET['status']))
{
    $sqli = $conn->query("SELECT a.id as order_id,a.*,b.*,c.color,c.unit as c_unit FROM `tbl_order` a inner join tbl_motorcycle b on a.motor_id=b.id inner join tbl_motorcycle_color c on a.color_id=c.id where a.branch_delivery='$my_branch' order by  a.id desc");
}else{
    $status=$_GET['status'];
   
    $sqli = $conn->query("SELECT a.id as order_id,a.*,b.*,c.color,c.unit as c_unit FROM `tbl_order` a inner join tbl_motorcycle b on a.motor_id=b.id inner join tbl_motorcycle_color c on a.color_id=c.id where a.branch_delivery='$my_branch' and a.status='$status' order by  a.id desc");
    switch ($status) {
        case 'wait_confirm':
            $ck1="selected";
            break; 
        case 'confirm':
            $ck2="selected";
            break; 
        case 'delivery':
            $ck3="selected";
            break; 
        case 'success':
            $ck4="selected";
            break; 
        case 'failed':
            $ck5="selected";
            break; 
    }
}
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
                        <li><a href="#" class="active">รายการรับเรื่องจองรถจักรยานยนต์</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="cart-main-area mb-10">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12 text-center">
                <h3>รายการรับเรื่องจองรถจักรยานยนต์</h3>
                <h5>สาขา <span class="fred">[ <?=$zone_name?> ] <?=$branch_name?></span></h5>
               
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4 mb-3">
            <form  method="get">
                   <select name="status" class="form-control" onchange="$('#btn').click();" id="">
                       <option value="">ทั้งหมด</option>
                       <option value="wait_confirm" <?=$ck1?>>สั่งจองรถ</option>
                       <option value="confirm" <?=$ck2?>>ยืนยันคำสั่งจอง</option>
                       <option value="delivery" <?=$ck3?>>กำลังดำเนินการ</option>
                       <option value="success" <?=$ck4?>>สำเร็จ</option>
                       <option value="failed" <?=$ck5?>>ล้มเหลว</option>
                   </select>
                   <input type="submit" id="btn" style="display:none;">
                </form>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered" width="100%">
                        <thead>
                            <tr>
                                <td width="5%">ลำดับ</td>
                                <td width="10%">ยี่ห้อ</td>
                                <td width="20%">ชื่อรุ่น</td>
                                <td width="10%">รหัส Code</td>
                                <td width="10%" class="text-center">สี</td>
                                <td width="5%" class="text-center">จำนวน</td>
                                <td width="20%" class="text-center">สาขาสั่งจอง</td>
                                <td width="10%" class="text-center">สถานะ</td>
                                <td width="10%" class="text-center">จัดการ</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                           
                    if($sqli->num_rows>0)
                    { 
                        $i=1;

                        while ($rr=$sqli->fetch_assoc()) {
                             $motor_id=$rr['id'];

                             ?>
                            <tr>
                                <td><?=$i?></td>
                                <td><?=$rr['brand']?></td>
                                <td><?=$rr['name']?></td>
                                <td><?=$rr['code']?></td>
                                <td><?=$rr['color']?></td>
                                <td><?=$rr['unit']?></td>
                              
                                <?php
                                $branch_order=$rr['branch_order'];
                                $sql2=$conn->query("SELECT a.branch_name,b.zone_name FROM `tbl_branch` a inner join tbl_zone b on a.zone_id=b.id WHERE a.id='$branch_order'");
                                list($branch_name,$zone_name)=mysqli_fetch_row($sql2);
                                ?>
                                <td>[ <?=$zone_name?> ] <?=$branch_name?></td>

                                <td class="text-center">
                                    <p><?=$arr_status[$rr['status']]?></p>
                            </td>

                                
                                <td class="text-center">
                                    <?php
                                    if($rr['status']=="wait_confirm")
                                    {
                                        ?>
                         <a  class="btn btn-success btn-sm fwhite" onclick="$('#modal_confirm #order_id').val(<?=$rr['order_id']?>);$('#modal_confirm #unit').html(<?=$rr['c_unit']?>)" data-toggle="modal" data-target="#modal_confirm"><span class="fas fa-pencil-alt "></span> ยืนยัน</a>
                         <a  class="btn btn-danger btn-sm fwhite" onclick="$('#modal_failed #order_id').val(<?=$rr['order_id']?>)" data-toggle="modal" data-target="#modal_failed"><span class="fas fa-pencil-alt "></span> ปฏิเสธ</a>
                                        <?php
                                    }else if($rr['status']=="confirm")
                                    {
                                        ?>
                                     <a  class="btn btn-info btn-sm fwhite" onclick="to_delivery(<?=$rr['order_id']?>)"> ยืนยันดำเนินการ</a>
                       
                                        <?php
                                        
                                    }
                                    ?>
                               
                                   
                                </td>
                            </tr>
                            <?php

                            $i++;
                        
                        }
                        
                    }
                    ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
    include("footer.php");

    ?>


<div class="modal fade" id="modal_confirm">
  <div class="modal-dialog">
    <div class="modal-content">
    <form id="form_confirm"> 
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">ยืนยันการสั่งจองรถ</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
     

      <!-- Modal body -->
      <div class="modal-body">
            <div class="row">
                <div class="col-12">
                <p style="color:red;">รถในคลังมี <span id="unit"></span> คัน</p>
                </div>
                <div class="col-12">
                    <span>หมายเหตุ</span>
                    <textarea name="note" class="form-control" id="" cols="30" rows="5"></textarea>
                </div>
            </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
          <input type="hidden" id="order_id" name="order_id">
        <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
        <button type="submit" class="btn btn-success" >ตกลง</button>
      </div>
      </form>

    </div>
  </div>
</div>



<div class="modal fade" id="modal_failed">
  <div class="modal-dialog">
    <div class="modal-content">
    <form id="form_failed">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">ปฏิเสธการสั่งจองรถ</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
       
            <div class="row">
                <div class="col-12">
                    <span>หมายเหตุ</span>
                    <textarea name="note" class="form-control" id="" cols="30" rows="5"></textarea>
                </div>
            </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
          <input type="hidden" id="order_id" name="order_id">
        <button type="button" class="btn btn-danger" data-dismiss="modal">ยกเลิก</button>
        <button type="submit" class="btn btn-success" ">ตกลง</button>
      </div>
      </form>

    </div>
  </div>
</div>






<script>
    $(document).ready(function() {
    $("#form_confirm").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append("act", "form_confirm");
        $.ajax({
            url: "sql.php",
            type: "POST",
            data: formData,
            success: function(data) {
                var obj=JSON.parse(data);

                if(obj['tus']=="success")
                {
                    alert_success(
                        "success",
                        "Success",
                        "ทำรายการสำเร็จ ",
                        "reload"
                    );
                }else{
                    alert_success(
                        "error",
                        "สั่งจองไม่ได้ ",
                        "กรุณาตรวจสอบข้อมูลก่อนทำรายการ ",
                        "false"
                    );

                }
            },
            cache: false,
            contentType: false,
            processData: false,
        });
    });
    $("#form_failed").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append("act", "form_failed");
        $.ajax({
            url: "sql.php",
            type: "POST",
            data: formData,
            success: function(data) {
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


function to_delivery(id){
    $.ajax({
            url: "sql.php",
            type: "POST",
            data: {
                act:"to_delivery",order_id:id
            },
            success: function(data) {
                alert_success(
                        "success",
                        "Success",
                        "ทำรายการสำเร็จ ",
                        "reload"
                    );
            }
        });
}
function search_branch(id) {
        var b = $("#branch_id").val();
        window.location = "order_check_list.php?branch_id=" + b;
    }
</script>