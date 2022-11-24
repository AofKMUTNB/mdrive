<?php
include("head.php");
if(empty($_SESSION['user-id'])){echo "<script>window.location='login.php'</script>";}
else{
    if($_SESSION['user-type']!="admin")
    {
    echo "<script>window.location='check_user.php';</script>";
        
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
                        <li><a href="#" class="active">พนักงาน</a></li>
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
                <h3>จัดการพนักงาน</h3>
                <a href="employee_add.php"><button type="button"
                        class="btn btn-primary btn-sm">เพิ่มพนักงาน</button></a>
            </div>
            <div class="col-md-8">
            </div>

            <div class="col-md-4 mb-3">
                <span>สาขา</span>
                <select class="js-example-basic-single form-control" name="branch_id" id="branch_id"
                    onchange="search_branch();">
                    <option value="all"  selected >ทั้งหมด</option>

                    <?php
                    $sqli = $conn->query("SELECT `id`,`branch_name` FROM `tbl_branch` "); //Searchเฉพาะid ชื่อ สาขา
                    while ($r=$sqli->fetch_assoc()) {
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
                                <td width="5%">รหัส</td>
                                <td width="12%">ชื่อ</td>
                                <td width="13%">นามสกุล</td>
                                <td width="8%">เบอร์โทร</td>
                                <td width="10%">อีเมล</td>
                                <td width="8%"> ตำแหน่ง</td>
                                <td width="10%">สาขา</td>
                                <td width="7%" class="text-center">แก้ไข</td>
                                <td width="7%" class="text-center">ลบ</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                        $myid=$_SESSION['user-id'];

                            if(empty($_GET['branch_id']) || $_GET['branch_id']=="all")
                            {
                                $sqli = $conn->query("SELECT * FROM `tbl_employee` where id!='$myid'");

                            }else{
                                $branch_id=$_GET['branch_id'];
                                $sqli = $conn->query("SELECT * FROM `tbl_employee` where id!='$myid' and branch='$branch_id'");

                            }
                    if($sqli->num_rows>0)
                    {
                        $i=1;
                        
                        while ($row=$sqli->fetch_assoc()) {
                            $branch_id=$row['branch'];
                            $sql2=$conn->query("SELECT a.branch_name,b.zone_name FROM `tbl_branch` a inner join tbl_zone b on a.zone_id=b.id WHERE a.id='$branch_id'");
                            list($branch_name,$zone_name)=mysqli_fetch_row($sql2);
                        ?>
                            <tr>
                                <td><?=$i?></td>
                                <td><?=$row['id']?></td>
                                <td><?=$row['name']?></td>
                                <td><?=$row['surname']?></td>
                                <td><?=$row['phone']?></td>
                                <td><?=$row['email']?></td>
                                <td><?=$row['position']?></td>
                                <td>[<?=$zone_name?>] <?=$branch_name?></td>
                                <td class="text-center">
                                <a href="employee_edit.php?id=<?=$row['id']?>" class="btn btn-warning btn-sm"><span class="fas fa-pencil-alt "></span> แก้ไข </a>
                                              
                                </td>
                                <td class="text-center">
                                    <a href="#" onclick="how_del(1,<?=$row['id']?>,'reload')" class="btn btn-danger btn-sm"><span class="far fa-trash-alt  "></span> ลบ</a>
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
   
    function search_branch(id) {
        var b = $("#branch_id").val();
        window.location = "index.php?branch_id=" + b;
    }
   
   var table = $('#dataTable').DataTable({
    searchHighlight: true,
language: {
        searchPlaceholder: "รหัส,ชื่อ-นามสกุล,สาขา"
    }
});
$('.dataTables_filter input').unbind().on('keyup', function() {
	var searchTerm = this.value.toLowerCase();
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
	   if (~data[2].toLowerCase().indexOf(searchTerm)) return true;
	   if (~data[1].toLowerCase().indexOf(searchTerm)) return true;
	   if (~data[8].toLowerCase().indexOf(searchTerm)) return true;
       return false;
   })
   table.draw(); 
   $.fn.dataTable.ext.search.pop();
});
 




</script>