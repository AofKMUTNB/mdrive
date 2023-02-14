<?php
include("head.php");
if(empty($_SESSION['user-id'])){echo "<script>window.location='login.php'</script>";}

?>


<div class="breadcrumbs-area mb-20">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumbs-menu">
                    <ul>
                        <li><a href="#">หน้าหลัก</a></li>
                        <li><a href="index.php">พนักงาน</a></li>
                        <li><a href="#" class="active">เพิ่มพนักงาน</a></li>
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
                <h3>เพิ่มพนักงาน</h3>
            </div>
            <div class="col-lg-12">
                <form id="form_add_employee">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <span>ชื่อ *</span>
                            <input type="text" class="form-control" name="firstname" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <span>นามสกุล *</span>
                            <input type="text" class="form-control" name="surname" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <span>เบอรโทร *</span>
                            <input type="text" class="form-control" name="phone"  maxlength="10" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <span>อีเมล *</span>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                       
                        <div class="col-lg-4 form-group">
                            <span>ตำแหน่ง *</span>
                            <select name="position" required class="form-control" id="">
                                <option value="" selected disabled>เลือก</option>
                                <option value="admin">แอดมิน</option>
                                <option value="staff">พนักงานคลังสินค้า</option>
                                <option value="sale">พนักงานขาย</option>
                            </select>
                        </div>
                        <div class="col-lg-5 form-group">
                            <span>สาขา</span>
                            <select name="branch_id" class="form-control" required id="">
                            <option value="" selected disabled>เลือก</option>
                                <?php
                              $sql=$conn->query("SELECT * FROM `tbl_zone` order by id asc");
                              while ($r=$sql->fetch_assoc()) {
                                  $zone_id=$r['id'];
                                  $sql2=$conn->query("SELECT * FROM `tbl_branch` WHERE `zone_id`='$zone_id'");
                                  while ($row=$sql2->fetch_assoc()) {
                                     ?>
                                <option value="<?=$row['id']?>">[<?=$r['zone_name']?>] <?=$row['branch_name']?></option>
                                <?php
                                  }
                              }
                              ?>
                            </select>
                        </div>
                        <div class="col-lg-6 form-group">
                            <span>Username</span>
                            <input type="text" required class="form-control" name="username">
                        </div>
                        <div class="col-lg-6 form-group">
                            <span>Password</span>
                            <input type="password" class="form-control inputpsw" name="password" required>
                            <i class="fa fa-eye buttonview" ></i>
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
    $(document).ready(function() {
    $("#form_add_employee").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append("act", "form_add_employee");
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