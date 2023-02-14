<?php
include("head.php");
if(empty($_SESSION['user-id'])){echo "<script>window.location='login.php'</script>";}
if(empty($_GET['branch_id']))
{
    $branch_id=$_SESSION['user-branch'];

}else{
    $branch_id=$_GET['branch_id'];

}
$sql2=$conn->query("SELECT a.branch_name,b.zone_name FROM `tbl_branch` a inner join tbl_zone b on a.zone_id=b.id WHERE a.id='$branch_id'");
list($branch_name,$zone_name)=mysqli_fetch_row($sql2);

if(empty($_GET['key']))
{
    $sqli = $conn->query("SELECT * FROM `tbl_motorcycle` where branch_id='$branch_id' order by id asc");
    $key="";
}else{
    $key=$_GET['key'];
    $sqli = $conn->query("SELECT * FROM `tbl_motorcycle` where branch_id='$branch_id' and (`name` LIKE '%$key%' OR `code` LIKE '%$key%' OR `brand` LIKE '%$key%') order by id asc");

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
                        <li><a href="#" class="active">รายการรถจักรยานยนต์</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="cart-main-area mb-10">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12 text-center mb-3">
                <h3>รายการรถจักรยานยนต์</h3>

                <h5>สาขา <span class="fred">[ <?=$zone_name?> ] <?=$branch_name?></span></h5>
                <a href="motorcycle_add.php?branch_id=<?=$branch_id?>"><button type="button"
                        class="btn btn-info btn-sm mb-2">เพิ่มรถจักรยานยนต์</button></a>
                <a href="pdf/report_motorcycle.php?branch_id=<?=$branch_id?>&key=<?=$key?>" target="_blank"><button type="button"
                        class="btn btn-primary btn-sm mb-2"><span class="fa fa-file-pdf-o"></span> รายงานสินค้าคงคลัง
                        PDF</button></a>
                <a download="รายงานสรุปจํานวนรถจักรยานยนต์ในคลัง สาขา[ <?=$zone_name?> ] <?=$branch_name?> [<?=date('d-m-Y')?>]" id="anchorNewApi-xls"
                    onclick="return newApi('xls','รายงานสรุปจํานวนรถจักรยานยนต์ในคลัง สาขา[ <?=$zone_name?> ] <?=$branch_name?> [<?=date('d-m-Y')?>]');"><button
                        type="button" class="btn btn-success btn-sm mb-2"><span class="fa fa-file-excel-o"></span>
                        รายงานสินค้าคงคลัง .xls</button></a>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <form action="" method="get">
                    <input type="text" name="key" class="form-control" value="<?=$key?>" placeholder="Code , ชื่อรุ่น , ยี่ห้อ">
                    <button type="submit" style="display:none;"></button>
                </form>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered" width="100%">
                        <thead>
                            <tr>
                                <td width="5%">ลำดับ</td>
                                <td width="15%">CODE</td>
                                <td width="30%">ชื่อรุ่น</td>
                                <td width="10%">ประเภท</td>
                                <td width="10%">ยี่ห้อ</td>
                                <td width="20%" class="text-center">สี/จำนวน</td>
                                <td width="10%" class="text-center">จัดการ</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                    if($sqli->num_rows>0)
                    { 
                        $i=1;

                        while ($rr=$sqli->fetch_assoc()) {
                             $mainID=$rr['id'];

                             ?>
                            <tr>
                                <td><?=$i?></td>
                                <td><?=$rr['code']?></td>
                                <td><?=$rr['name']?></td>
                                <td><?=$rr['type']?></td>
                                <td><?=$rr['brand']?></td>
                                <td>
                                    <?php
                                        $sqli2=$conn->query("SELECT color,unit FROM `tbl_motorcycle_color` where mainID='$mainID' order by id asc");
                                        while ($row=$sqli2->fetch_assoc()) {
                                            if(!empty($row['color']))
                                            {
                                                ?>

                                    <div class="row mb-3">
                                        <div class="col-lg-6">
                                            <span class=""><?=$row['color']?></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <span class=""><?=$row['unit']?></span>
                                        </div>



                                    </div>
                                    <?php
                                            }
                                           
                                        }
                                            
                                    ?>
                                </td>

                                <td class="text-center">
                                    <a href="motorcycle_edits.php?motor_id=<?=$rr['id']?>"
                                        class="btn btn-warning btn-sm"><span class="fas fa-pencil-alt "></span> แก้ไข
                                    </a>
                                    <a onclick="how_del(4,<?=$rr['id']?>,'reload')" class="btn btn-danger btn-sm"><span
                                            class="far fa-trash-alt  "></span> ลบ</a>
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

<script>
    function newApi(format, filnames) {
        return ExcellentExport.convert({
            anchor: 'anchorNewApi-' + format,
            filename: filnames,
            format: format
        }, [{
            name: 'Sheet1',
            from: {
                table: 'datatable1'
            }
        }]);

    }
</script>


<div style="display:none;">
    <table id="datatable1" style="width: 100%;">

        <tr>
            <th style="text-align:center;background-color:#ccc;" width="10%">ยี่ห้อ </th>
            <th style="text-align:center;background-color:#ccc;" width="30%">รุ่น </th>
            <th style="text-align:center;background-color:#ccc;" width="30%">รหัส </th>
            <th style="text-align:center;background-color:#ccc;" width="20%">สี </th>
            <th style="text-align:center;background-color:#ccc;" width="10%">จำนวน </th>
        </tr>
        <?php
if(empty($_GET['key']))
{
    $sqli = $conn->query("SELECT * FROM `tbl_motorcycle` where branch_id='$branch_id' order by id asc");
}else{
    $sqli = $conn->query("SELECT * FROM `tbl_motorcycle` where branch_id='$branch_id' and (`name` LIKE '%$key%' OR `code` LIKE '%$key%' OR `brand` LIKE '%$key%') order by id asc");

}
while ($row=$sqli->fetch_assoc()) {
  $motor_id=$row['id'];
$sql5=$conn->query("SELECT `color`,`unit` FROM `tbl_motorcycle_color` WHERE `mainID`='$motor_id'");
while ($r=$sql5->fetch_assoc()) {
    if($r['unit']>0)
    {
       ?>
        <tr>

            <td style="text-align:left;"><?=$row['brand']?></td>
            <td style="text-align:left;"><?=$row['name']?> </td>
            <td style="text-align:left;"><?=$row['code']?></td>
            <td style="text-align:center;"><?=$r['color']?></td>
            <td style="text-align:center;"><?=$r['unit']?></td>
        </tr>
        <?php
    }
   
}


}
    ?>


    </table>
</div>







<script>
    var table = $('#dataTable').DataTable({
        searchHighlight: true,
        language: {
            searchPlaceholder: "Code , ชื่อรุ่น , ยี่ห้อ"
        },
        searching: false
    });
    // $('.dataTables_filter input').unbind().on('keyup', function () {
    //     var searchTerm = this.value.toLowerCase();
    //     $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    //         if (~data[2].toLowerCase().indexOf(searchTerm)) return true;
    //         if (~data[1].toLowerCase().indexOf(searchTerm)) return true;
    //         if (~data[4].toLowerCase().indexOf(searchTerm)) return true;
    //         return false;
    //     })
    //     table.draw();
    //     $.fn.dataTable.ext.search.pop();
    // });
</script>