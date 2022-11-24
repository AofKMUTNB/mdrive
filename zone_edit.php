<?php
include("head.php");
if(empty($_SESSION['user-id'])){echo "<script>window.location='login.php'</script>";}
$zone_id=$_GET['id'];
$sqli=$conn->query("SELECT * FROM `tbl_zone` WHERE `id`='$zone_id'");
while ($row=$sqli->fetch_assoc()) {

?>


<div class="breadcrumbs-area mb-20">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumbs-menu">
                    <ul>
                        <li><a href="#">หน้าหลัก</a></li>
                        <li><a href="zone_list.php">โซน</a></li>
                        <li><a href="#" class="active">แก้ไขโซน</a></li>
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
                <h3>แก้ไขโซน</h3>
            </div>
            <div class="col-lg-12">
                <form id="form_edit_zone">
                    <div class="row">
                        <div class="col-lg-12 form-group">
                            <span>ชื่อโซน *</span>
                            <input type="text" class="form-control" name="zone_name" required value="<?=$row['zone_name']?>">
                        </div>
                       
                        <div class="col-lg-12 mt-3 mb-3 text-center">
                            <input type="hidden" name="id" value="<?=$zone_id?>">
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
    $(document).ready(function() {
    $("#form_edit_zone").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append("act", "form_edit_zone");
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
</script>