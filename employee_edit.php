<?php
include("head.php");
if(empty($_SESSION['user-id'])){echo "<script>window.location='login.php'</script>";}

$id=$_GET['id'];
$sqli=$conn->query("SELECT * FROM `tbl_employee` WHERE `id`='$id'");
while ($row=$sqli->fetch_assoc()) {
  

?>


<div class="breadcrumbs-area mb-20">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumbs-menu">
                    <ul>
                        <li><a href="#">หน้าหลัก</a></li>
                        <li><a href="index.php">พนักงาน</a></li>
                        <li><a href="#" class="active">แก้ไขข้อมูลพนักงาน</a></li>
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
                <h3>แก้ไขข้อมูลพนักงาน</h3>
            </div>
            <div class="col-lg-12 mt-3">
                <form id="form_edit_employee">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <span>ชื่อ *</span>
                            <input type="text" class="form-control" name="firstname" required value="<?=$row['name']?>">
                        </div>
                        <div class="col-lg-6 form-group">
                            <span>นามสกุล *</span>
                            <input type="text" class="form-control" name="surname" required value="<?=$row['surname']?>">
                        </div>
                        <div class="col-lg-6 form-group">
                            <span>เบอรโทร *</span>
                            <input type="text" class="form-control" name="phone" maxlength="10" required value="<?=$row['phone']?>">
                        </div>
                        <div class="col-lg-6 form-group">
                            <span>อีเมล *</span>
                            <input type="email" class="form-control" name="email" required value="<?=$row['email']?>">
                        </div>
                      
                        <div class="col-lg-4 form-group">
                            <span>ตำแหน่ง *</span>
                            <select name="position" required class="form-control" >
                                <option value="" selected disabled>เลือก</option>
                                <?php $chk1="";$chk2="";$chk3="";
                                if($row['position']=="admin"){$chk1="selected";}
                                else if($row['position']=="staff"){$chk2="selected";}
                                else if($row['position']=="sale"){$chk3="selected";}

                                ?>
                                <option value="admin" <?=$chk1?>>แอดมิน</option>
                                <option value="staff" <?=$chk2?>>พนักงานคลังสินค้า</option>
                                <option value="sale" <?=$chk3?>>พนักงานขาย</option>
                            </select>
                        </div>
                        <div class="col-lg-5 form-group">
                            <span>สาขา</span>
                            <select name="branch_id" class="form-control" required >
                            <option value="" selected disabled>เลือก</option>
                                <?php
                              $sql=$conn->query("SELECT * FROM `tbl_zone` order by id asc");
                              while ($r=$sql->fetch_assoc()) {
                                  $zone_id=$r['id'];
                                  $sql2=$conn->query("SELECT * FROM `tbl_branch` WHERE `zone_id`='$zone_id'");
                                  while ($rr=$sql2->fetch_assoc()) {
                                      if($row['branch']==$rr['id'])
                                      {
                                          $chk="selected";
                                      }else{$chk="";}
                                     ?>
                                <option value="<?=$rr['id']?>" <?=$chk?>>[<?=$r['zone_name']?>] <?=$rr['branch_name']?></option>
                                <?php
                                  }
                              }
                              ?>
                            </select>
                        </div>
                        <div class="col-lg-6 form-group">
                            <span>Username</span>
                            <input type="text" required class="form-control" name="username" value="<?=$row['username']?>">
                        </div>
                        <div class="col-lg-6 form-group">
                            <span>Password</span>
                            <input type="password" class="form-control inputpsw" name="password" required value="<?=$row['password']?>">
                            <i class="fa fa-eye buttonview" ></i>
                        </div>
                        <div class="col-lg-12 mt-3 mb-3 text-center">
                            <input type="hidden" name="user_id" value="<?=$_GET['id']?>">
                         <a href="index.php">  <button type="button"  class="btn btn-danger">ยกเลิก</button></a>
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

    $(document).ready(function() {
        
    $("#form_edit_employee").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append("act", "form_edit_employee");
        $.ajax({
            url: "sql.php",
            type: "POST",
            data: formData,
            success: function(data) {
                var obj = JSON.parse(data);
                if (obj.status == "success") {
                    alert_success(
                        "success",
                        "Success",
                        "ทำรายการสำเร็จ ",
                        "index.php"
                    );

                } else {
                    alert_success("error", "Not Found", "Username ซ้ำ", "false");


                }
            },
            cache: false,
            contentType: false,
            processData: false,
        });
    });


});
$('.buttonview').on('click', function() { $('.inputpsw').attr('type', 'text'); })
    .on('mouseout', function() { $('.inputpsw').attr('type', 'password'); });
</script>

<style>
    .buttonview{
        position: absolute;
    right: 27px;
    bottom: 12px;
    }


    @media only screen and (max-width: 767.98px) {
        .buttonview{
            position: absolute;
    right: 30px;
    bottom: 10px;
    }
}

    </style>