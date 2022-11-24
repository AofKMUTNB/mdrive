<?php
 require("../conf.php");

    $arr=array();
        $name=$_POST['name'];
        $code=$_POST['code'];
        $brand=$_POST['brand'];
        $type=$_POST['type'];
        $c_color=$_POST['c_color'];
$datenow=date("Y-m-d H:i:s");

        $conn->query("INSERT INTO `motorcycle_center`(`type`, `brand`, `code`, `name`,  `update_at`) VALUES ('$type','$brand','$code','$name','$datenow')");

        $sqli=$conn->query("SELECT `id` FROM `motorcycle_center`  ORDER BY `id` DESC");
        list($last_id)=mysqli_fetch_row($sqli);

        for ($i=1; $i <= $c_color; $i++) { 
            if(!empty($_POST['color'][$i]) && !empty($_POST['unit'][$i]))
                {
                    $color=$_POST['color'][$i];
                    $unit=$_POST['unit'][$i];
                    
                    $conn->query("INSERT INTO `motorcycle_color_center`( `motor_id`, `color_name`, `stock`) VALUES ('$last_id','$color','$unit')");
                }
        }
       
  echo json_encode($arr);

?>