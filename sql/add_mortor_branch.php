<?php
 require("../conf.php");

    $arr=array();
       
        $c_color=$_POST['c_color'];
        $branch_id=$_POST['branch_id'];
        $motor_id=$_POST['motor_id'];
        $datenow=date("Y-m-d H:i:s");

        $s=$conn->query("SELECT `type`, `brand`, `code`,`name` FROM `motorcycle_center` WHERE `id`='$motor_id'");
        list($type,$brand,$code,$name)=mysqli_fetch_row($s);
        $sss=$conn->query("SELECT `id` FROM `tbl_motorcycle` WHERE `motor_id`='$motor_id' and `branch_id`='$branch_id'");
        if($sss->num_rows==0)
        {
            $conn->query("INSERT INTO `tbl_motorcycle`( `type`, `brand`, `name`, `code`, `branch_id`, `motor_id`) VALUES ('$type','$brand','$name','$code','$branch_id','$motor_id')");

            $sqli=$conn->query("SELECT `id` FROM `tbl_motorcycle`  ORDER BY `id` DESC");
            list($mainID)=mysqli_fetch_row($sqli);
        }else{
            list($mainID)=mysqli_fetch_row($sss);
            
        }

      $sum_unit=0;
        for ($i=1; $i <= $c_color; $i++) { 
            if(!empty($_POST['color'][$i]) && !empty($_POST['unit'][$i]))
                {
                    $color_id=$_POST['color'][$i];
                    $unit=$_POST['unit'][$i];
                    $sum_unit+=$unit;

                    $sqli=$conn->query("SELECT  `color_name`, `stock` FROM `motorcycle_color_center` WHERE `color_id`='$color_id'");
                    list($color_name,$stock)=mysqli_fetch_row($sqli);
                    if($unit>$stock)
                    {
                        $unit=$stock;
                    }

                    
                    $ss=$conn->query("SELECT `id` FROM `tbl_motorcycle_color` WHERE `mainID`='$mainID' AND `color_id`='$color_id'");
                    if($ss->num_rows>0)
                    {
                        $conn->query("UPDATE `tbl_motorcycle_color` SET `unit`=`unit`+'$unit' WHERE `mainID`='$mainID' AND `color_id`='$color_id'");

                            $addunit=$unit;
                       
                    }else{

                        $conn->query("INSERT INTO `tbl_motorcycle_color`( `mainID`, `color_id`, `color`, `unit`) VALUES ('$mainID','$color_id','$color_name','$unit')");
                        $sss=$conn->query("SELECT `unit` FROM `tbl_motorcycle_color` WHERE `id`='$color_id'");
                        list($last_unit)=mysqli_fetch_row($sss);
                        $addunit=$unit-$last_unit;
                    }
                    if($addunit>0)
                    {
                        $conn->query("UPDATE `motorcycle_color_center` SET `stock`=`stock`-'$addunit' WHERE `color_id`='$color_id'");

                    }

                    
                }
        }


        if($_SESSION['user-type']=="admin")
        {
            $txt="แอดมินได้เพิ่มรถ Code : $code ให้สาขาคุณ จำนวน $sum_unit คัน เมื่อเวลา $datenow ";
            $conn->query("INSERT INTO `tbl_notication`(`branch_id`, `txt`, `update_at`, `statis`) VALUES ('$branch_id','$txt','$datenow','0')");

        }else{
            $txt="พนักงานรหัส ".$_SESSION['user-id']." ชื่อ ".$_SESSION['user-fullname']." ได้เพิ่มรถ Code : $code ให้สาขาคุณ จำนวน $sum_unit คัน  เมื่อเวลา $datenow ";

            $conn->query("INSERT INTO `tbl_notication`(`branch_id`, `txt`, `update_at`, `statis`) VALUES ('$branch_id','$txt','$datenow','0')");

        }


  echo json_encode($arr);

?>