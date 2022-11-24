<?php
 require("../conf.php");

    $arr=array();
        $motor_id=$_POST['ids'];
       
        $sqli=$conn->query("SELECT `id`, `type`, `brand`, `code`, `name`, `update_at` FROM `motorcycle_center` WHERE `id`='$motor_id'");
        while ($row=$sqli->fetch_assoc()) {
           $arr['type']=$row['type'];
           $arr['brand']=$row['brand'];
           $arr['code']=$row['code'];
           $arr['name']=$row['name'];
           $arr['id']=$row['id'];
        }

       
       
  echo json_encode($arr);

?>