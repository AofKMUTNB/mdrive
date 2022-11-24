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
                        <li><a href="#" class="active">โซน</a></li>
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
                <h3>จัดการโซน</h3>
                <a href="zone_add.php"><button type="button"
                        class="btn btn-primary btn-sm">เพิ่มโซน</button></a>
            </div>
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered" width="100%">
                        <thead>
                            <tr>
                                <td width="10%">ลำดับ</td>
                                <td width="80%">ชื่อ</td>
                                <td width="5%" class="text-center">แก้ไข</td>
                                <td width="5%" class="text-center">ลบ</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                    $sqli = $conn->query("SELECT * FROM `tbl_zone`");
                    if($sqli->num_rows>0)
                    { $i=1;
                        while ($row=$sqli->fetch_assoc()) {
                           
                        ?>
                            <tr>
                                <td><?=$i?></td>
                                <td><?=$row['zone_name']?></td>
                                <td>
                                <a href="zone_edit.php?id=<?=$row['id']?>" class="btn btn-warning btn-sm"><span class="fas fa-pencil-alt "></span> แก้ไข </a>
                                
                                </td>
                                <td class="text-center">
                                 <a  onclick="how_del(2,<?=$row['id']?>,'reload')" class="btn btn-danger btn-sm fwhite"><span class="far fa-trash-alt  "></span> ลบ</a>
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