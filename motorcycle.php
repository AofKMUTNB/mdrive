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
            <div class="col-lg-12 text-center">
                <h3>รายการรถจักรยานยนต์</h3>
               
                        <a href="motorcycle_stock_add.php" ><button type="button"
                        class="btn btn-info btn-sm mb-2">เพิ่มรถจักรยานยนต์</button></a> 
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
                    $sqli = $conn->query("SELECT `id`, `type`, `brand`, `code`, `name`,  `update_at` FROM `motorcycle_center` ORDER BY `id` asc");
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
                                <td><?=$rr['brand']?></td>
                                <td>
                                    <?php
                                        $sqli2=$conn->query("SELECT `color_id`, `motor_id`, `color_name`, `stock` FROM `motorcycle_color_center` WHERE `motor_id`='$motor_id'");
                                        while ($row=$sqli2->fetch_assoc()) {
                                            if(!empty($row['color_name']))
                                            {
                                                ?>
                                                
                                                <div class="row mb-3">
                                        <div class="col-lg-6">
                                            <span class=""><?=$row['color_name']?></span>
                                        </div>
                                        <div class="col-lg-6">
                                            <span class=""><?=$row['stock']?></span>
                                        </div>
                                       


                                    </div>
                                                <?php
                                            }
                                           
                                        }
                                            
                                    ?>
                                </td>

                                <td class="text-center">
                                    <a href="motorcycle_stock_edit.php?motor_id=<?=$rr['id']?>" class="btn btn-warning btn-sm"><span
                                            class="fas fa-pencil-alt "></span> แก้ไข </a>
                                    <a onclick="how_del_motorcycle_center(<?=$rr['id']?>)" class="btn btn-danger btn-sm"><span
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
            filename: filnames ,
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

$sqli=$conn->query("SELECT * FROM `tbl_motorcycle` WHERE `branch_id`='$branch_id'");

while ($row=$sqli->fetch_assoc()) {
  $motor_id=$row['id'];
$sql5=$conn->query("SELECT `color`,`unit` FROM `tbl_motorcycle_color` WHERE `mainID`='$motor_id'");
while ($r=$sql5->fetch_assoc()) {
    if($r['unit']>0)
    {
       ?>
 <tr>
           
           <td style="text-align:left;"><?=$row['brand']?></td>
           <td style="text-align:left;" ><?=$row['name']?> </td>
           <td style="text-align:left;"><?=$row['code']?></td>
           <td style="text-align:center;" ><?=$r['color']?></td>
           <td style="text-align:center;" ><?=$r['unit']?></td>
       </tr>
       <?php
    }
   
}


}
    ?>
              
                
    </table>
</div>






  
<script>
   var table = $('#dataTable').DataTable({                  //search
    searchHighlight: true,
language: {
        searchPlaceholder: "Code , ชื่อรุ่น"
    }
});
$('.dataTables_filter input').unbind().on('keyup', function() {
	var searchTerm = this.value.toLowerCase();
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
	   if (~data[2].toLowerCase().indexOf(searchTerm)) return true;
	   if (~data[1].toLowerCase().indexOf(searchTerm)) return true;
       return false;
   })
   table.draw(); 
   $.fn.dataTable.ext.search.pop();
});






function how_del_motorcycle_center(motor_id) {        //ลบ
        Swal.fire({
        title: "คุณต้องการลบข้อมูลใช่หรือไม่?",
        text: "ข้อมูลทั้งหมดที่เกี่ยวข้องกับรหัสนี้ จะถูกลบออกทั้งหมดทันที",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "ใช่ ลบเลย!",
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "sql/del_motor_center.php",
                type: "post",
                data: {
                    ids: motor_id
                },
                success: function(data) {
                    console.log(data);
                    Swal.fire({
                        icon: "success",
                        title: "ทำรายการสำเร็จ",
                        text: "",
                    }).then((result) => {
                        if (result.value) {
                            location.reload();

                        }
                    });
                },
            });
        }
    });

    }
</script>