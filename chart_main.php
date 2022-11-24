<?php
include("head.php");
if(empty($_SESSION['user-id'])){echo "<script>window.location='login.php'</script>";}
if(empty($_GET['branch_id']))
{
    $my_branch=$_SESSION['user-branch'];
}else{
    $my_branch=$_GET['branch_id'];

}
$sql2=$conn->query("SELECT a.branch_name,b.zone_name FROM `tbl_branch` a inner join tbl_zone b on a.zone_id=b.id WHERE a.id='$my_branch' ");
list($branch_name,$zone_name)=mysqli_fetch_row($sql2);
 
?>
<input type="hidden" id="branch_id" value="<?=$my_branch?>">

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
                        <li><a href="order_list.php" class="">รายการสั่งจองรถจักรยานยนต์</a></li>
                        <li><a href="#" class="active">รายงานแผนภูมิการสั่จองรถจักรยานยนต์</a></li>
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
                <h3>รายงานแผนภูมิการสั่จองรถจักรยานยนต์</h3>
                <h5>สาขา <span class="fred">[ <?=$zone_name?> ] <?=$branch_name?></span></h5>

            </div>
            <div class="col-md-12 mt-5 mb-2">
                <form  >
                    <div class="row">
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <span>เดือนเริ่มต้น</span>
                                    <select   class="form-control" id="m_start" name="m_start" required>
                                        <option value="">เลือก</option>
                                        <?php
                                        for ($i=1; $i <13 ; $i++) { 
                                            ?>
                                        <option value="<?=$i?>" ><?=$arr_month[$i]?></option>
                                            <?php
                                        }
                                        ?>
                                       
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <span>เดือนสิ้นสุด</span>
                                    <select   class="form-control" id="m_stop" name="m_stop" required>
                                        <option value="">เลือก</option>
                                        <?php
                                        for ($i=1; $i <13 ; $i++) { 
                                            ?>
                                        <option value="<?=$i?>"  ><?=$arr_month[$i]?></option>
                                            <?php
                                        }
                                        ?>
                                       
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <span>ปี</span>
                            <select name="year" class="form-control" id="year" required>
                                <?php
                                for ($i=(date("Y")+543) ; $i >2560; $i--) { 
                                    ?>
                                    <option value="<?=$i?>"><?=$i?></option>
                                    <?php
                                }
                                ?></select>
                        </div>
                        <div class="col-md-2">
                            <span>ยี่ห้อ</span>
                            <select name="brand" class="form-control" id="brand" onchange="change_brand()" required>
                                <option value="">เลือก</option>
                                <option value="HONDA">HONDA</option>
                                <option value="YAMAHA">YAMAHA</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <span>Code </span>
                            <select class="form-control" name="code_id" id="code_id" onchange="change_code()" required>
                                <option value="">เลือก</option>
                                    
                            </select>
                        </div>
                        <div class="col-md-2">
                            <span>สี </span>
                            <select class="form-control"  name="color" id="color" >
                                <option value="">เลือก</option>
                                    
                            </select>
                        </div>
                        <div class="col-md-1">
                            <br>
                            <button class="btn btn-info" type="button" onclick="showGraph()">SHOW</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12">
                <div id="chart-container">
                    <canvas id="graphCanvas"></canvas>
                </div>

                <script>
                    


                  
                </script>
            </div>

        </div>

    </div>
</div>

<?php
    include("footer.php");

    ?>

 

<script>

    function change_brand() {
        $.ajax({
            url: "sql/load_code_branch.php",
            type: "POST",
            data: {
                branch_id: $("#branch_id").val()
            },
            success: function (data) {
                var obj = JSON.parse(data);
                var tbody = "<option value='all'>ทั้งหมด</option>";
                for (var i = 0; i < obj['num_data']; i++) {
                    tbody += "<option value='" + obj[i]['code'] + "'>" + obj[i]['code'] + "</option>";

                }
                $("#code_id").html(tbody);
            }
        });
    }

    function change_code() {
        if($("#code_id").val()!="all")
        {
            $.ajax({
            url: "sql/load_color_branch.php",
            type: "POST",
            data: {
                id: $("#code_id").val(),branch_id:$("#branch_id").val()
            },
            success: function (data) {
                console.log(data);
                var obj = JSON.parse(data);
                var tbody = "<option value='all'>ทั้งหมด</option>";
                for (var i = 0; i < obj['num_data']; i++) {
                    tbody += "<option value='" + obj[i]['id'] + "'>" + obj[i]['color'] + "</option>";

                }
                console.log(tbody);
                $("#color").html(tbody);
            }
        });
        }else{
            $("#color").html("<option value=''>เลือก</option>");

        }

        
    }



    function showGraph() {
                        if($("#m_start").val()==""){$("#m_start").focus();return false;}
                        else if($("#m_stop").val()==""){$("#m_stop").focus();return false;}
                        else if($("#brand").val()==""){$("#brand").focus();return false;}
                        else if($("#code_id").val()==""){$("#code_id").focus();return false;}
                        else if($("#code_id").val()!="all" && $("#color").val()==""){$("#color").focus();return false;}
                        else{
                            $.ajax({
                            url: "sql.php",
                            type: "POST",
                            data: {
                                act: "show_chart",
                                my_branch: $("#branch_id").val(),
                                m_start:$("#m_start").val(),
                                m_stop:$("#m_stop").val(),
                                year:$("#year").val(),
                                brand:$("#brand").val(),
                                code_id:$("#code_id").val(),
                                color:$("#color").val()
                            },
                            success: function (obj) {
                                console.log(obj);
                                var data = JSON.parse(obj);
                                var name = [];
                                var unit = [];
                                var color = [];

                                for (var i in data) {
                                    if(data[i].month=="1"){var txt_month="มกราคม";}
                                    else if(data[i].month=="2"){var txt_month="กุมภาพันธ์";}
                                    else if(data[i].month=="3"){var txt_month="มีนาคม";}
                                    else if(data[i].month=="4"){var txt_month="เมษายน";}
                                    else if(data[i].month=="5"){var txt_month="พฤษภาคม";}
                                    else if(data[i].month=="6"){var txt_month="มิถุนายน";}
                                    else if(data[i].month=="7"){var txt_month="กรกฏาคม";}
                                    else if(data[i].month=="8"){var txt_month="สิงหาคม";}
                                    else if(data[i].month=="9"){var txt_month="กันยายน";}
                                    else if(data[i].month=="10"){var txt_month="ตุลาคม";}
                                    else if(data[i].month=="11"){var txt_month="พฤศจิกายน";}
                                    else if(data[i].month=="12"){var txt_month="ธันวาคม";}
                                    name.push( " เดือน " + txt_month+" ปี "+($("#year").val()-543));
                                    unit.push(data[i].unit);
                                }
                                var chartdata = {
                                    labels: name,
                                    datasets: [{
                                        label: 'รายการสั่งจองรถจักรยานยนต์ ',
                                        backgroundColor: '#49e2ff',
                                        borderColor: '#46d5f1',
                                        hoverBackgroundColor: '#CCCCCC',
                                        hoverBorderColor: '#666666',
                                        data: unit
                                    }]
                                };
                                $('#graphCanvas').remove();
  $('#chart-container').append('<canvas id="graphCanvas"><canvas>');
                                var graphTarget = $("#graphCanvas");

                                var barGraph = new Chart(graphTarget, {
                                    type: 'bar',
                                    data: chartdata
                                });
                            }
                        });

                        }
                    }
</script>