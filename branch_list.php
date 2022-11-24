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
                        <li><a href="#" class="active">สาขา</a></li>
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
                <h3>จัดการสาขา</h3>
                <a href="branch_add.php"><button type="button" class="btn btn-primary btn-sm">เพิ่มสาขา</button></a>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered" width="100%">
                        <thead>
                            <tr>
                                <td width="5%">ลำดับ</td>
                                <td width="25%">โซน</td>
                                <td width="35%">ชื่อสาขา</td>
                                <td width="15%" class="text-center">รถจักรยานยนต์</td>
                                <td width="10%" class="text-center">แก้ไข</td>
                                <td width="10%" class="text-center">ลบ</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                    $sqli = $conn->query("SELECT * FROM `tbl_zone` order by id asc");
                    if($sqli->num_rows>0)
                    { 
                        $i=1;

                        while ($rr=$sqli->fetch_assoc()) {
                             $zone_id=$rr['id'];
                             $sqli2=$conn->query("SELECT * FROM `tbl_branch` where zone_id='$zone_id' order by id asc");

                             while ($row=$sqli2->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <td><?=$i?></td>
                                        <td><?=$rr['zone_name']?></td>
                                        <td><?=$row['branch_name']?></td>
                                        <td class="text-center">
                                        <a href="motorcycle_list.php?branch_id=<?=$row['id']?>" class="btn btn-info btn-sm"><span
                                                    class="	fa fa-motorcycle"></span> ดูรายการ </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="branch_edit.php?id=<?=$row['id']?>" class="btn btn-warning btn-sm"><span
                                                    class="fas fa-pencil-alt "></span> แก้ไข </a>
                                        </td>
                                         <td class="text-center">
                                            <a onclick="how_del(3,<?=$row['id']?>,'reload')" class="btn btn-danger btn-sm"><span
                                                    class="far fa-trash-alt  "></span> ลบ</a>
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