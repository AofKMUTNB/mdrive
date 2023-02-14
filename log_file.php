<?php
include("head.php");
if(empty($_SESSION['user-id'])){echo "<script>window.location='login.php'</script>";}
if(!empty($_GET['date']))
{
    $date=$_GET['date'];
}else{$date="";}
?>


<div class="breadcrumbs-area mb-20">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumbs-menu">
                    <ul>
                        <li><a href="#">หน้าหลัก</a></li>
                        <li><a href="#" class="active">ประวัติการเข้าใช้งาน</a></li>
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
                <h3>ประวัติการเข้าใช้งาน</h3>
            </div>
           
            <div class="col-md-12 mb-3 text-center">
               <input type="date" class="form-control w-25 mr-0" placeholder="dd/mm/YYYY" value="<?=$date?>" id="search_date" onchange="search_date();">
            </div>


            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered" width="100%">
                        <thead>
                            <tr>
                                <td width="30%">ผู้ใช้</td>
                                <td width="30%">สาขา</td>
                                <td width="25%">วัน/เวลา</td>
                               
                                <td width="15%" class="text-center">จัดการ</td>
                                <td style="display:none;"></td>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(!empty($_GET['date']))
                            {
                                $sqli = $conn->query("SELECT a.*,b.name,b.surname,b.branch FROM `tbl_log` a inner join tbl_employee b on a.user_id=b.id where Date(a.date_time)='$date' order by a.date_time desc");

                            }else{
                                $sqli = $conn->query("SELECT a.*,b.name,b.surname,b.branch  FROM `tbl_log` a inner join tbl_employee b on a.user_id=b.id order by a.date_time desc");

                            }
                    if($sqli->num_rows>0)
                    { 
                        $i=1;

                        while ($rr=$sqli->fetch_assoc()) {
                            $branch_id=$rr['branch'];
                            $sql2=$conn->query("SELECT a.branch_name,b.zone_name FROM `tbl_branch` a inner join tbl_zone b on a.zone_id=b.id WHERE a.id='$branch_id'");
                            list($branch_name,$zone_name)=mysqli_fetch_row($sql2);
                            $date=date_create($rr['date_time']);

                            ?>
                                    <tr>
                                        <td><?=$rr['name']." ".$rr['surname']?></td>
                                        <td>[<?=$zone_name?>] <?=$branch_name?></td>
                                        <td><?=date_format($date, "d/m/Y H:i:s");?></td>
                                       
                                        <td class="text-center">
                                           
                                            <a onclick="how_del(6,<?=$rr['id']?>,'reload')" class="btn btn-danger btn-sm fwhite"><span
                                                    class="far fa-trash-alt  "></span> ลบ</a>
                                        </td>
                                        <td style="display:none;"><?=$rr['date_time']?></td>
                                    </tr>
                                    <?php
                        
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
 function search_date(){
        window.location="log_file.php?date="+$("#search_date").val();
    }


   var table = $('#dataTable').DataTable({
    searchHighlight: true,
language: {
        searchPlaceholder: "ชื่อ - นามสกุล"
    },
order: [[ 4, 'desc' ]]
});
$('.dataTables_filter input').unbind().on('keyup', function() {
	var searchTerm = this.value.toLowerCase();
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
	   if (~data[0].toLowerCase().indexOf(searchTerm)) return true;
       return false;
   })
   table.draw(); 
   $.fn.dataTable.ext.search.pop();
});
</script>