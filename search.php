
<?php
include("head.php");
if(empty($_SESSION['user-id'])){echo "<script>window.location='login.php'</script>";}
$chk1="";
$chk2="";
$mybranch=$_SESSION['user-branch'];
if(!empty($_GET['brand']) && !empty($_GET['code'])){
$brand=$_GET['brand'];
$code=rewriteLink1($_GET['code']);
if($brand=="HONDA"){$chk1="selected";}else{$chk2="selected";}
}else{
    $brand="";
    $code="";
   
}

?>

<div class="breadcrumbs-area mb-20">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumbs-menu">
                    <ul>
                        <li><a href="#">หน้าหลัก</a></li>
                        <li><a href="#" class="active">ค้นหารถสั่งจอง</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="cart-main-area mb-10">
    <div class="container">
        <form id="search_form">
            <div class="row">
                <div class="col-lg-5 form-group">
                    <span>ยี่ห้อ</span>
                    <select name="brand" id="brand" class="form-control">
                        <option value="HONDA" <?=$chk1?>>HONDA</option>
                        <option value="YAMAHA" <?=$chk2?>>YAMAHA</option>
                    </select>
                </div>
                <div class="col-lg-5 form-group">
                    <span>CODE เลขรหัสรุ่น</span>
                    <select class="js-example-basic-single form-control" name="code" id="code">
                        <?php
                    $sqli = $conn->query("SELECT `code` FROM `motorcycle_center` group by `code`");
                    while ($r=$sqli->fetch_assoc()) {
                        if($_GET['code']==$r['code']){$chk="selected";}else{$chk="";}
                        ?>
                        <option value="<?=$r['code']?>" <?=$chk?>><?=$r['code']?></option>

                        <?php
                    }

                    ?>
                    </select>
                </div>
                <div class="col-lg-2 form-group">
                    <br>
                    <button type="submit" class="btn btn-primary ">ตรวจสอบ</button>
                </div>
            </div>
        </form>
    </div>



    <div class="container-fluid">

        <div class="row">

            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered" width="100%">
                        <thead>
                            <tr>
                                <td width="5%">ลำดับ</td>
                                <td width="15%">CODE</td>
                                <td width="25%">ชื่อรุ่น</td>
                                <td width="10%">ประเภท</td>
                                <td width="25%" class="text-center">สี/จำนวน</td>
                                <td width="20%" class="text-center">สาขา</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if($_SESSION['user-type']=="admin")
                            {
                                $sqli = $conn->query("SELECT * FROM `tbl_motorcycle` where brand='$brand' and code ='$code' order by id asc");

                            }else{
                                $sqli = $conn->query("SELECT * FROM `tbl_motorcycle` where brand='$brand' and branch_id!='$mybranch' and code LIKE '%$code%'  order by id asc");

                            }
                             if($sqli->num_rows>0)
                             { 
                                 $i=1;

                                 while ($rr=$sqli->fetch_assoc()) {
                                     $motor_id=$rr['id'];
                                     ?>
                            <tr>
                                <td><?=$i?></td>
                                <td><?=$rr['code']?></td>
                                <td><?=$rr['name']?></td>
                                <td><?=$rr['type']?></td>
                                <td>
                                    <?php
                                                 $sqli2=$conn->query("SELECT id,color,unit FROM `tbl_motorcycle_color` where mainID='$motor_id' order by id asc");
                                                 while ($row=$sqli2->fetch_assoc()) {
                                                     if(!empty($row['color']))
                                                     {
                                                         ?>
                                    <div class="row mb-3">
                                        <div class="col-lg-5">
                                            <span class=""><?=$row['color']?></span>
                                        </div>
                                        <div class="col-lg-3">
                                            <span class=""><?=$row['unit']?></span>
                                        </div>
                                        <div class="col-lg-4">
                                            <a href="order.php?motor_id=<?=$rr['id']?>&color_id=<?=$row['id']?>"
                                                class="btn btn-info btn-sm "><span class="fas fa-pencil-alt "></span>
                                                สั่งจอง
                                            </a>
                                        </div>


                                    </div>



                                    <?php
                                                     }
                                                 }
                                             ?>
                                </td>
                                <?php
                                         $branch_id=$rr['branch_id'];
                                         $sql2=$conn->query("SELECT a.branch_name,b.zone_name FROM `tbl_branch` a inner join tbl_zone b on a.zone_id=b.id WHERE a.id='$branch_id'");
                                         list($branch_name,$zone_name)=mysqli_fetch_row($sql2);
                                         ?>
                                <td>[ <?=$zone_name?> ] <?=$branch_name?></td>



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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<!-- นำเข้า Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" />

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<?php
    include("footer.php");

    ?>




<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        $('.js-example-basic-single').select2();

        $("#search_form").submit(function (e) {
            e.preventDefault();
            var brand = $("#brand").val();
            var code = $("#code").val();
            window.location = "search.php?brand=" + brand + "&code=" + code;
        });
        readtime();


        
    });
    function readtime(){
    setTimeout(function() { readtime(); }, 3000);
    $.ajax({
        url: "sql.php",
        type: "POST",
        data: {
            act: "check_my_order"
        },
        success: function(data) {
            var obj=JSON.parse(data);
            if(obj.num_data>0)
            {
                $(".noti1").html(obj.num_data);
                $(".noti1").addClass("show");
                $(".noti1").removeClass("hide");


            }else{
                $(".noti1").html("");
                $(".noti1").removeClass("show");
                $(".noti1").addClass("hide");


            }

        }
    });
}

</script>
<style>
.select2-results__options
{
    background: #000;
    color: #fff;
}
.noti1{
    position: absolute;
    top: 10px;
    left: 123px;
}
</style>
