<?php
include("head.php");
$ck1="";$ck2="";$ck3="";$ck4="";$ck5="";
$status="";
if(empty($_SESSION['user-id'])){echo "<script>window.location='login.php'</script>";}
if(empty($_GET['branch_id']))
{
    $my_branch=$_SESSION['user-branch'];
    $branch_id="";
}else{
    $my_branch=$_GET['branch_id'];
    $branch_id=$_GET['branch_id'];

}
if(!empty($_GET['branch_id']))
{

    $sql2=$conn->query("SELECT a.branch_name,b.zone_name FROM `tbl_branch` a inner join tbl_zone b on a.zone_id=b.id WHERE a.id='$my_branch' ");
    list($branch_name,$zone_name)=mysqli_fetch_row($sql2);

   
    if(!empty($_GET['status']))
    {
        $status=$_GET['status'];
        $sqli = $conn->query("SELECT a.id as order_id,a.*,b.*,c.color FROM `tbl_order` a inner join tbl_motorcycle b on a.motor_id=b.id inner join tbl_motorcycle_color c on a.color_id=c.id  where a.branch_order='$my_branch' and a.status='$status' order by a.date_order desc  ");
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

    }else{
        $sqli = $conn->query("SELECT a.id as order_id,a.*,b.*,c.color FROM `tbl_order` a inner join tbl_motorcycle b on a.motor_id=b.id inner join tbl_motorcycle_color c on a.color_id=c.id  where a.branch_order='$my_branch' order by a.date_order desc  ");
    }
}else{
    $branch_name="";$zone_name="";
    if(!empty($_GET['status']))
    {
        $status=$_GET['status'];
        
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
}
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<!-- นำเข้า Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" />

<div class="breadcrumbs-area mb-20">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumbs-menu">
                    <ul>
                        <li><a href="#">หน้าหลัก</a></li>
                        <li><a href="#" class="active">รายการสั่งจองรถจักรยานยนต์</a></li>
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
                <h3>รายการสั่งจองรถจักรยานยนต์</h3>
                <h5>สาขา <span class="fred">[ <?=$zone_name?> ] <?=$branch_name?></span></h5>
            </div>
            <div class="col-12 text-center mb-3">
           <?php
           if(!empty($_GET['branch_id']))
           {
               ?>
                
                <a href="pdf/report_order.php?branch_id=<?=$my_branch?>&status=<?=$status?>" target="_blank"><button type="button"
                        class="btn btn-primary btn-sm mb-2"><span class="fa fa-file-pdf-o"></span> รายงานการสั่งจอง
                        PDF</button></a>
                <a download="รายงานการสั่งจอง[<?=date('d-m-Y')?>]" id="anchorNewApi-xls"
                    onclick="return newApi('xls','รายงานการสั่งจอง[<?=date('d-m-Y')?>]');"><button type="button"
                        class="btn btn-success btn-sm mb-2"><span class="fa fa-file-excel-o"></span> รายงานการสั่งจอง
                        .xls</button></a>
               
           
               <?php
           }
           ?>

<a href="chart_main.php?branch_id=<?=$my_branch?>"><button type="button"
                        class="btn btn-secondary btn-sm mb-2"><span class="fa fa-bar-chart"></span>
                        รายงานแผนภูมิ</button></a>
                        </div>
<div class="col-md-4"></div>
            <div class="col-md-4 mb-3">
            <form  method="get">
                   <select name="status" id="status" class="form-control" onchange="$('#btn').click();" id="">
                       <option value="">ทั้งหมด</option>
                       <option value="wait_confirm" <?=$ck1?>>สั่งจองรถ</option>
                       <option value="confirm" <?=$ck2?>>ยืนยันคำสั่งจอง</option>
                       <option value="delivery" <?=$ck3?>>กำลังดำเนินการ</option>
                       <option value="success" <?=$ck4?>>สำเร็จ</option>
                       <option value="failed" <?=$ck5?>>ล้มเหลว</option>
                   </select>
                   <input type="hidden" name="branch_id" value="<?=$branch_id?>">
                   <input type="submit" id="btn" style="display:none;">
                </form>
            </div>
          
            <div class="col-md-8">
            </div>

            <div class="col-md-4 mb-3">
                <span>สาขา</span>
                <select class="js-example-basic-single form-control" name="branch_id" id="branch_id"
                    onchange="search_branch();">
                    <option value="" disabled selected >เลือก</option>

                    <?php
                    $sqli2 = $conn->query("SELECT `id`,`branch_name` FROM `tbl_branch` ");
                    while ($r=$sqli2->fetch_assoc()) {
                        if($_GET['branch_id']==$r['id']){$chk="selected";}else{$chk="";}
                        ?>
                    <option value="<?=$r['id']?>" <?=$chk?>><?=$r['branch_name']?></option>

                    <?php
                    }

                    ?>
                </select>
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
                                <td width="20%" class="text-center">สาขาจัดส่ง</td>
                                <td width="10%" class="text-center">สถานะ</td>
                                <td width="10%" class="text-center">จัดการ</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(!empty($_GET['branch_id']))
                            {
                                
                                
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
                                            $branch_delivery=$rr['branch_delivery'];
                                            $sql2=$conn->query("SELECT a.branch_name,b.zone_name FROM `tbl_branch` a inner join tbl_zone b on a.zone_id=b.id WHERE a.id='$branch_delivery'");
                                            list($branch_name,$zone_name)=mysqli_fetch_row($sql2);
                                            ?>
                                <td>[ <?=$zone_name?> ] <?=$branch_name?></td>
                                <td class="text-center">
                                    <p><?=$arr_status[$rr['status']]?></p>
                                    <a href="order_detail.php?order_id=<?=$rr['order_id']?>&branch_id=<?=$my_branch?>"
                                        class="btn btn-secondary btn-sm fwhite"><span class="fa fa-eye "></span> ดูสถานะ
                                    </a>
                                </td>


                                <td class="text-center">
                                    <p><a href="pdf/document1.php?order_id=<?=$rr['order_id']?>"
                                            class="btn btn-info btn-sm" target="_blank"><span class="fa fa-file"></span>
                                            ใบสั่งจอง
                                        </a></p>
                                    <?php
                                                if($rr['status']=="wait_confirm")
                                                {
                                                    ?>
                                    <a href="order_edit.php?order_id=<?=$rr['order_id']?>"
                                        class="btn btn-warning btn-sm"><span class="fas fa-pencil-alt "></span> แก้ไข
                                    </a>
                                    <a onclick="how_del(5,<?=$rr['order_id']?>,'reload')"
                                        class="btn btn-danger btn-sm fwhite"><span class="far fa-trash-alt  "></span>
                                        ลบ</a>
                                    <?php
                                                }else if($rr['status']=="delivery")
                                                {
                                                    ?>
                                    <a class="btn btn-success btn-sm fwhite"
                                        onclick="to_success(<?=$rr['order_id']?>)"><span class="fa fa-check "></span>
                                        รับรถแล้ว
                                    </a>

                                    <?php
                                                }else if($rr['status']=="failed")
                                                {
                                                    ?>
                                    <a onclick="how_del(5,<?=$rr['order_id']?>,'reload')"
                                        class="btn btn-danger btn-sm fwhite"><span class="far fa-trash-alt  "></span>
                                        ลบ</a>
                                    <?php
                                                }
                                                ?>


                                </td>
                            </tr>
                            <?php
                                        $i++;
            
                                       
                                    
                                    }
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

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>

<script>
 
    $(document).ready(function () {
        $('.js-example-basic-single').select2();

    });

    function to_success(id) {
        $.ajax({
            url: "sql.php",
            type: "POST",
            data: {
                act: "to_success",
                order_id: id
            },
            success: function (data) {
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
        var status = $("#status").val();
        window.location = "order_list_admin.php?branch_id=" + b+"&status="+status;
    }
</script>






<div style="display:none;">
    <table id="datatable1" class="table table-bordered" width="100%">
        <tr>
            <td width="5%">ลำดับ</td>
            <td width="10%">ยี่ห้อ</td>
            <td width="20%">ชื่อรุ่น</td>
            <td width="10%">รหัส Code</td>
            <td width="10%" class="text-center">สี</td>
            <td width="5%" class="text-center">จำนวน</td>
            <td width="10%" class="text-center">สาขาจัดส่ง</td>
            <td width="10%" class="text-center">คนสั่ง</td>
            <td width="10%" class="text-center">สถานะ</td>
        </tr>
        <tbody>
            <?php
            if(!empty($status))
            {
                $sqli = $conn->query("SELECT a.id as order_id,a.*,b.*,c.color,d.name as 'user_name',d.surname as 'user_surname' FROM `tbl_order` a inner join tbl_motorcycle b on a.motor_id=b.id inner join tbl_motorcycle_color c on a.color_id=c.id inner join tbl_employee d on a.user_id=d.id where a.branch_order='$my_branch' and a.status='$status' order by a.status desc , a.id desc");

            }else{
                $sqli = $conn->query("SELECT a.id as order_id,a.*,b.*,c.color,d.name as 'user_name',d.surname as 'user_surname' FROM `tbl_order` a inner join tbl_motorcycle b on a.motor_id=b.id inner join tbl_motorcycle_color c on a.color_id=c.id inner join tbl_employee d on a.user_id=d.id where a.branch_order='$my_branch' order by a.status desc , a.id desc");

            }
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
                                $branch_delivery=$rr['branch_delivery'];
                                $sql2=$conn->query("SELECT a.branch_name,b.zone_name FROM `tbl_branch` a inner join tbl_zone b on a.zone_id=b.id WHERE a.id='$branch_delivery'");
                                list($branch_name,$zone_name)=mysqli_fetch_row($sql2);
                                ?>
                <td>[ <?=$zone_name?> ] <?=$branch_name?></td>
                <td class="text-center"><?=$rr['user_name']." ".$rr['user_surname']?> </td>
                <td class="text-center"><?=$arr_status[$rr['status']]?> </td>
            </tr>
            <?php
                            $i++;

                           
                        
                        }
                    }
                    ?>
        </tbody>
    </table>

</div>