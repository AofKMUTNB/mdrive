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
                        <?php
                        if($_SESSION['user-type']=="admin")
                        {
                            ?><li><a href="branch_list.php" class="">สาขา</a></li><?php
                        }
                        ?>
                        <li><a href="#" class="active">เพิ่มสาขา</a></li>
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
                <h3>เพิ่มสาขา</h3>
            </div>
            <div class="col-lg-12">
                <form id="form_add_branch">
                    <div class="row">
                        <div class="col-lg-8 form-group">
                            <span>ชื่อสาขา *</span>
                            <input type="text" class="form-control" name="branch_name" required>
                        </div>
                        <div class="col-lg-4 form-group">
                            <span>โซน *</span>
                            <select name="zone_id" class="form-control" required id="">
                            <option value="" selected disabled>เลือก</option>
                                <?php
                              $sql=$conn->query("SELECT * FROM `tbl_zone` order by id asc");
                              while ($r=$sql->fetch_assoc()) {
                                ?>
                                <option value="<?=$r['id']?>"><?=$r['zone_name']?></option>
                                <?php
                              }
                              ?>
                            </select>
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
    $("#form_add_branch").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append("act", "form_add_branch");
        $.ajax({
            url: "sql.php",
            type: "POST",
            data: formData,
            success: function(data) {
                alert_success(
                        "success",
                        "Success",
                        "ทำรายการสำเร็จ ",
                        "branch_list.php"
                    );
            },
            cache: false,
            contentType: false,
            processData: false,
        });
    });


});
</script>