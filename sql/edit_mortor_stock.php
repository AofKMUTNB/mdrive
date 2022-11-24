<?php
 require("../conf.php");

    $arr=array();
        $name=$_POST['name'];
        $code=$_POST['code'];
        $brand=$_POST['brand'];
        $type=$_POST['type'];
        $c_color=$_POST['c_color'];
        $id=$_POST['id'];
$datenow=date("Y-m-d H:i:s");

        $conn->query("UPDATE `motorcycle_center` SET `type`='$type',`brand`='$brand',`code`='$code',`name`='$name',`update_at`='$datenow' WHERE id='$id'");


        for ($i=1; $i <= $c_color; $i++) { 
            if(!empty($_POST['color'][$i]) && !empty($_POST['unit'][$i]))
                {
                    $color=$_POST['color'][$i];
                    $unit=$_POST['unit'][$i];

                    if(!empty($_POST['color_id'][$i]))
                    {
                        $color_id=$_POST['color_id'][$i];
                    $conn->query("UPDATE `motorcycle_color_center` SET `color_name`='$color',`stock`='$unit' WHERE `color_id`='$color_id'");

                    }else{
                        $conn->query("INSERT INTO `motorcycle_color_center`( `motor_id`, `color_name`, `stock`) VALUES ('$id','$color','$unit')");

                    }
                    
                }
        }
       
  echo json_encode($arr);

?>