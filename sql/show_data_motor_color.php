<?php
 require("../conf.php");

    $arr=array();
        $motor_id=$_POST['ids'];
       $i=0;
        $sqli=$conn->query("SELECT `color_id`, `motor_id`, `color_name`, `stock` FROM `motorcycle_color_center` WHERE `motor_id`='$motor_id'");
       $arr['num_data']=$sqli->num_rows;

        while ($row=$sqli->fetch_assoc()) {
           $arr[$i]['color_id']=$row['color_id'];
           $arr[$i]['motor_id']=$row['motor_id'];
           $arr[$i]['color_name']=$row['color_name'];
           $arr[$i]['stock']=$row['stock'];
           $i++;
        }

       
       
  echo json_encode($arr);

?>